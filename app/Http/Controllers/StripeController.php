<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\payments ;
use App\Models\Orders;
class StripeController extends Controller
{
     // تأكد من إضافة هذا السطر بالأعلى

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

    // ✅ تسجيل الطلب في جدول orders
    $orderInfo = session()->get('order_info'); // يجب أن تكون محفوظة مسبقاً
    $orderProducts = $items->map(function ($item) {
        return [
            'product_id' => $item->product_id,
            'quantity' => $item->quantity
        ];
    });

    Orders::create([
        'user_id' => $userId,
        'store_id' => $storeId,
        'products' => json_encode($orderProducts),
        'total_quantity' => $items->sum('quantity'),
        'state_of_order' => 'waiting',
        'state_of_payment' => $session->payment_status ?? 'paid',
        'user_address' => $orderInfo['user_address'] ?? 'N/A',
        'user_phone_number' => $orderInfo['user_phone'] ?? 'N/A',
        'user_email' => $orderInfo['user_email'] ?? 'N/A',
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

    // تحديث المخزون أو تعطيل المنتج لو نفد
    foreach ($items as $item) {
        $product = $item->product;
        $product->stock -= $item->quantity;

        if ($product->stock <= 0) {
            $product->stock = 0;
            $product->is_active = false; // تعطيل المنتج
            $product->save();

            if ($storeOwner) {
                Notification::create([
                    'user_id' => $storeOwner->id,
                    'title' => 'Product Out of Stock',
                    'message' => "The product '{$product->name}' is now out of stock.",
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

    // تنظيف بيانات الجلسة
    session()->forget(['stripe_sessions', 'order_info']);

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


