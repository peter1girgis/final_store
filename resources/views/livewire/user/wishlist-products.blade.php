<div class="container py-4">
    <h3 class="mb-4">My Wishlist</h3>

    <div class="row">
        @forelse ($wishlistProducts as $product)
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100 position-relative">
            {{-- Out of Stock Label --}}
            @if (!$product->is_active || $product->stock == 0)
                <div class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end" style="z-index: 5;">
                    Out of Stock
                </div>
            @endif

            {{-- Main Image --}}
            @if ($product->main_image)
                <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
            @endif

            {{-- Body --}}
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text text-muted">{{ $product->description }}</p>
                <p class="card-text"><strong>${{ $product->price }}</strong></p>

                <div class="d-flex justify-content-between mt-3">
                    <button wire:click="toggleWishlist({{ $product->id }})"
                            class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-heart-broken"></i> Remove
                    </button>

                    <button wire:click="addToCart({{ $product->id }})"
                            class="btn btn-sm btn-outline-success"
                            @if (!$product->is_active || $product->stock == 0) disabled @endif>
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-info">Your wishlist is empty.</div>
    </div>
@endforelse

    </div>
</div>
