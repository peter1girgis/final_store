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

    // استخراج بيانات المتجر الحالي من session
    $data = collect($stripeSessions)->firstWhere('session_id', $sessionId);

    if (!$data) {
        return redirect()->route('cart')->with('error', 'Session not found.');
    }

    $storeId = $data['store_id'];

    // جلب المنتجات الخاصة بالمتجر
    $items = CartItem::with('product.store')
        ->where('user_id', $userId)
        ->whereHas('product', fn($q) => $q->where('store_id', $storeId))
        ->get();

    if ($items->isEmpty()) {
        return redirect()->route('cart')->with('error', 'No items found for this store.');
    }

    $store = $items->first()->product->store;
    $storeOwner = $store->user ?? null;

    // تعديل الكمية في الكارت لو تجاوزت المخزون
    foreach ($items as $item) {
        $product = $item->product;

        if ($item->quantity > $product->stock) {
            $item->quantity = $product->stock;
        }

        if ($item->quantity <= 0) {
            continue;
        }

        $item->save();
    }

    // فلترة المنتجات بعد التعديل
    $items = $items->filter(fn($item) => $item->quantity > 0);

    $productNames = $items->pluck('product.name')->implode(', ');
    $totalAmount = $items->sum(fn($item) => $item->product->price * $item->quantity);

    // حفظ كل منتج في صف منفصل داخل جدول payments
    foreach ($items as $item) {
        $product = $item->product;
        $quantity = $item->quantity;
        $totalPrice = $product->price * $quantity;

        payments::create([
            'user_id' => $userId,
            'store_id' => $storeId,
            'payment_id' => $session->id,
            'product_id' => $product->id,
            'total_quantity' => $quantity,
            'amount' => $totalPrice,
            'currency' => $session->currency,
            'payment_status' => $session->payment_status ?? 'paid',
            'stripe_store_account_id' => $store->stripe_account_id,
        ]);
    }

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

    // تحديث المخزون أو حذف المنتج لو نفد
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

    // حذف المنتجات من الكارت
    CartItem::where('user_id', $userId)
        ->whereIn('id', $items->pluck('id'))
        ->delete();

    // حذف بيانات stripe session من الـ session
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


