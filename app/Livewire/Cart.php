<?php

namespace App\Livewire;

use App\Models\CartItem;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{
    public $cartItems = [];
    public function payWithStripe()
{
    $userId = Auth::id();
    $items = CartItem::with('product.store')->where('user_id', $userId)->get();

    $groupedItems = $items->groupBy(fn($item) => $item->product->store->id);

    foreach ($groupedItems as $storeId => $storeItems) {
        $lineItems = [];
        $store = $storeItems->first()->product->store;

        foreach ($storeItems as $item) {
            $unitAmount = $item->product->price * 100;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => $item->product->name],
                    'unit_amount' => $unitAmount,
                ],
                'quantity' => $item->quantity,
            ];
        }

        $stripe = new StripeClient(config('stripe.stripe_sk'));

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
        ]);

        // احفظ مؤقتًا الـ session_id مع user_id و store_id
        session()->push('stripe_sessions', [
            'store_id' => $store->id,
            'session_id' => $session->id
        ]);

        return redirect()->away($session->url); // خلي دي ترجع أول Session فقط (واحدة واحدة)
    }
}


    public function mount()
    {
        $this->cartItems = Auth::user()->cartItems()->with('product')->get();
    }

    public function incrementQuantity($itemId)
    {
        $item = CartItem::find($itemId);
        $item->increment('quantity');
        $this->refreshCart();
    }

    public function decrementQuantity($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item->quantity > 1) {
            $item->decrement('quantity');
        } else {
            $item->delete();
        }
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $this->cartItems = Auth::user()->cartItems()->with('product')->get();
    }

    public function getTotalProperty()
    {
        return $this->cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    }
    public function render()
    {
        return view('livewire.cart')->layout('layouts.user_layout');
    }
}
