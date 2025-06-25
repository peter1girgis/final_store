<div class="container py-5">
    <h2>Your Cart</h2>

    @forelse($cartItems as $item)
        <div style="padding-left: 9px; padding-right: 9px; padding-top: 7px;" class="card mb-3 p-3">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <img src="{{ asset('storage/' . $item->product->main_image) }}" class="img-fluid" style="height: 150px; object-fit: contain;">
                </div>
                <div class="col-md-5">
                    <h5>{{ $item->product->name }}</h5>
                    <p>{{ $item->product->description }}</p>
                    <p>Price: <strong>{{ $item->product->price }} EGP</strong></p>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <button wire:click="decrementQuantity({{ $item->id }})" class="btn btn-danger">-</button>
                        <input type="text" class="form-control text-center" value="{{ $item->quantity }}" readonly>
                        <button wire:click="incrementQuantity({{ $item->id }})" class="btn btn-success">+</button>
                    </div>
                    <p class="mt-2">Subtotal: <strong>{{ $item->product->price * $item->quantity }} EGP</strong></p>
                </div>
            </div>
        </div>
    @empty
        <p>No items in your cart.</p>
    @endforelse

    @if(count($cartItems) > 0)
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <h4>Total: <strong>{{ $this->total }} EGP</strong></h4>

            {{-- ✅ زر الدفع --}}
            <button wire:click="payWithStripe" class="btn btn-lg btn-outline-primary">
                <i class="fas fa-credit-card mr-2"></i> Checkout & Pay
            </button>
        </div>
    @endif
</div>

