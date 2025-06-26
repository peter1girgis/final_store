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

    $items = CartItem::with('product.store')
        ->where('user_id', $userId)
        ->get();

    if ($items->isEmpty()) {
        session()->flash('error', 'Cart is empty.');
        return;
    }

    // جَمِّع المنتجات حسب المتجر
    $groupedItems = $items->groupBy(fn($item) => $item->product->store->id);

    // خذ أول متجر فقط
    $storeId = $groupedItems->keys()->first();
    $storeItems = $groupedItems[$storeId];

    $store = $storeItems->first()->product->store;
    $lineItems = [];

    foreach ($storeItems as $item) {
        $product = $item->product;

        // ✅ تأكد إن المستخدم مش بيشتري أكتر من الموجود
        if ($item->quantity > $product->stock) {
            $item->quantity = $product->stock;

            // ولو الكمية بقت صفر، تجاهل المنتج
            if ($item->quantity <= 0) {
                continue;
            }

            // حدث الكمية الجديدة في cart مؤقتًا (اختياري)
            $item->save();
        }

        $unitAmount = $product->price * 100;

        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => $product->name],
                'unit_amount' => $unitAmount,
            ],
            'quantity' => $item->quantity,
        ];
    }

    // لو مفيش عناصر صالحة بعد التحقق
    if (empty($lineItems)) {
        session()->flash('error', 'No available stock to proceed with payment.');
        return;
    }

    $stripe = new StripeClient(config('stripe.stripe_sk'));

    $session = $stripe->checkout->sessions->create([
        'payment_method_types' => ['card'],
        'line_items' => $lineItems,
        'mode' => 'payment',
        'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('cancel'),
    ]);

    session()->put('stripe_sessions', [[
        'store_id' => $store->id,
        'session_id' => $session->id
    ]]);

    return redirect()->away($session->url);
}




    public function mount()
    {
        $this->cartItems = Auth::user()->cartItems()->with('product')->get();
    }

    public function incrementQuantity($itemId)
{
    $item = CartItem::find($itemId);

    if (!$item) {
        return;
    }

    $product = $item->product;

    if (!$product) {
        return;
    }

    // التحقق إذا كانت الكمية الجديدة لا تتجاوز المخزون
    if ($item->quantity + 1 > $product->stock) {
        $this->dispatch('return_operation_stopped');
        return;
    }

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
