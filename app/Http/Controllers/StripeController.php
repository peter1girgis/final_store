<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\payments ;

class StripeController extends Controller
{
    public function success(Request $request)
{
    $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
    $sessionId = $request->session_id;

    // استرجاع بيانات جلسة Stripe
    $session = $stripe->checkout->sessions->retrieve($sessionId, [
        'expand' => ['payment_intent']
    ]);

    $userId = auth()->id();
    $stripeSessions = session()->get('stripe_sessions', []);

    // استخراج البيانات الخاصة بالمتجر الحالي
    $data = collect($stripeSessions)->firstWhere('session_id', $sessionId);

    if (!$data) {
        return redirect()->route('cart')->with('error', 'Session not found.');
    }

    $storeId = $data['store_id'];

    // جلب المنتجات الخاصة بهذا المتجر فقط
    $items = CartItem::with('product.store')
        ->where('user_id', $userId)
        ->whereHas('product', fn($q) => $q->where('store_id', $storeId))
        ->get();

    if ($items->isEmpty()) {
        return redirect()->route('cart')->with('error', 'No items found for this store.');
    }

    $store = $items->first()->product->store;
    $storeOwner = $store->user ?? null;

    // تعديل الكمية في الكارت إذا تجاوزت المخزون
    foreach ($items as $item) {
        $product = $item->product;

        if ($item->quantity > $product->stock) {
            $item->quantity = $product->stock;
        }

        // إذا أصبحت الكمية 0 بعد التعديل
        if ($item->quantity <= 0) {
            continue; // تجاهل هذا المنتج
        }

        $item->save(); // لحفظ التعديل على الكمية
    }

    // إعادة تحميل العناصر بعد التعديلات
    $items = $items->filter(fn($item) => $item->quantity > 0);

    $totalQuantity = $items->sum('quantity');
    $totalAmount = $items->sum(fn($item) => $item->product->price * $item->quantity);
    $productNames = $items->pluck('product.name')->implode(', ');

    // حفظ عملية الدفع
    payments::create([
        'user_id' => $userId,
        'store_id' => $storeId,
        'payment_id' => $session->id,
        'product_names' => $productNames,
        'total_quantity' => $totalQuantity,
        'amount' => $totalAmount,
        'currency' => $session->currency,
        'payment_status' => $session->payment_status ?? 'paid',
        'stripe_store_account_id' => $store->stripe_account_id,
    ]);

    // إشعار للمشتري
    Notification::create([
        'user_id' => $userId,
        'title' => 'Payment Successful',
        'message' => "You paid $totalAmount USD for ($productNames).",
        'status' => 'unread',
        'type' => 'payment',
    ]);

    // إشعار للبائع
    if ($storeOwner) {
        Notification::create([
            'user_id' => $storeOwner->id,
            'title' => 'New Order Received',
            'message' => "You received $totalAmount USD for ($productNames).",
            'status' => 'unread',
            'type' => 'order',
        ]);
    }

    // تقليل الكمية أو حذف المنتجات المنتهية
    foreach ($items as $item) {
        $product = $item->product;
        $product->stock -= $item->quantity;

        if ($product->stock <= 0) {
            $productName = $product->name;
            $product->delete();

            if ($storeOwner) {
                Notification::create([
                    'user_id' => $storeOwner->id,
                    'title' => 'Product Out of Stock',
                    'message' => "The product '$productName' is now out of stock and has been removed from your store.",
                    'status' => 'unread',
                    'type' => 'warning',
                ]);
            }
        } else {
            $product->save();
        }
    }

    // حذف العناصر من السلة الخاصة بهذا المتجر فقط
    CartItem::where('user_id', $userId)
        ->whereIn('id', $items->pluck('id'))
        ->delete();

    // نسيان بيانات الجلسة
    session()->forget('stripe_sessions');

    return redirect()->route('payments')->with('message', [
        'type' => 'success',
        'text' => 'Payment done successfully.'
    ]);
}



    public function cancel()
    {
        return "Payment is canceled.";
    }
}


