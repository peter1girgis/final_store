<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\payments ;

class StripeController extends Controller
{
    public function success(Request $request)
{
    if (isset($request->session_id)) {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id, ['expand' => ['payment_intent']]);

        $userId = auth()->id();

        // Get products from cart
        $items = CartItem::with('product.store')->where('user_id', $userId)->get();

        $totalQuantity = $items->sum('quantity');
        $totalAmount = $items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $productNames = $items->pluck('product.name')->implode(', ');

        payments::create([
            'user_id' => $userId,
            'payment_id' => $session->id,
            'product_names' => $productNames,
            'total_quantity' => $totalQuantity,
            'amount' => $totalAmount,
            'currency' => $session->currency,
            'payment_status' => $session->payment_status ?? 'paid',
            'stripe_store_account_id' => optional($items->first()?->product?->store)->stripe_account_id,
        ]);

        // Optionally clear cart
        CartItem::where('user_id', $userId)->delete();

        return redirect()->route('payments');
 // أو صفحة شكرًا
    }

    return redirect()->route('cancel');
}
    public function cancel()
        {
            return "Payment is canceled.";
        }

}
