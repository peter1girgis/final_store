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

        $session = $stripe->checkout->sessions->retrieve($sessionId, [
            'expand' => ['payment_intent']
        ]);

        $userId = auth()->id();
        $stripeSessions = session()->get('stripe_sessions', []);

        foreach ($stripeSessions as $data) {
            if ($data['session_id'] === $sessionId) {
                $storeId = $data['store_id'];

                $items = CartItem::with('product.store')
                    ->where('user_id', $userId)
                    ->whereHas('product', fn($q) => $q->where('store_id', $storeId))
                    ->get();

                if ($items->isEmpty()) {
                    continue; // لا يوجد عناصر لهذا المتجر
                }

                $store = $items->first()->product->store;
                $storeOwner = $store->user ?? null;

                $totalQuantity = $items->sum('quantity');
                $totalAmount = $items->sum(fn($item) => $item->product->price * $item->quantity);
                $productNames = $items->pluck('product.name')->implode(', ');

                // حفظ الدفع
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

                // حذف العناصر من السلة الخاصة بهذا المتجر
                CartItem::where('user_id', $userId)
                    ->whereIn('id', $items->pluck('id'))
                    ->delete();

                break;
            }
        }

        session()->forget('stripe_sessions');

        return redirect()->route('payments')->with('message', [
            'type' => 'success',
            'text' => 'payment done successfully.'
        ]);

    }

    public function cancel()
    {
        return "Payment is canceled.";
    }
}


