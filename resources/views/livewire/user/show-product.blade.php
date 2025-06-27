<div class="container my-4">
    @if (!$product->is_active || $product->stock == 0)
        <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>This product is currently out of stock.</strong>
        </div>
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Starter Page</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                        <li class="breadcrumb-item active">product datails</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Basic Info -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title"><strong>product name : </strong>{{ $product->name }}</h4>
                    <p class="card-text"><strong>product description : </strong>{{ $product->description }}</p>
                    <p class="card-text"><strong>Store:</strong> {{ $product->store->store_name }}</p>

                    <div class="mt-3 d-flex justify-content-between">
                        <button wire:click="addToCart({{ $product->id }})"
                                class="btn btn-sm btn-outline-success"
                                @if (!$product->is_active || $product->stock == 0) disabled @endif>
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>

                        <button wire:click="addToWishlist({{ $product->id }})"
                                class="btn btn-sm {{ $inWishlist ? 'btn-danger' : 'btn-outline-primary' }}">
                            <i class="fas fa-heart"></i> {{ $inWishlist ? 'In Wishlist' : 'Add to Wishlist' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Image -->
        <div class="col-md-6 mb-4">
            <div class="card h-85 shadow">
                <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img-top" style="max-height: 400px; object-fit: contain;" alt="Main Image">
            </div>
        </div>

        <!-- Price & Stock -->
        <div class="col-md-12 mb-4">
            <div class="card h-100 shadow text-center">
                <div class="card-body">
                    <h5>
                        <span class="text-success mr-2">Price: ${{ $product->price }}</span>
                        @if($product->old_price)
                            <del class="text-muted ms-3 ml-2">${{ $product->old_price }}</del>
                        @endif
                    </h5>
                    <p>
                        <strong>Stock:</strong>
                        <span class="{{ $product->stock == 0 ? 'text-danger fw-bold' : '' }}">
                            {{ $product->stock }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Sub Images -->
        @if (!empty($product->sub_images) && is_array($product->sub_images) && count($product->sub_images) > 0)
            <div class="col-md-12 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5>Sub Images</h5>
                        <div class="d-flex overflow-auto" style="gap: 10px;">
                            @foreach ($product->sub_images as $image)
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $image) }}"
                                        class="rounded border"
                                        style="height: 190px; width: auto; object-fit: contain;"
                                        alt="Sub Image">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Categories -->
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5>Categories</h5>
                    <div class="d-flex flex-wrap gap-2 ">
                        @foreach ($product->categories as $category)
                            <span class="badge bg-primary m-2" style="font-size: 15px">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="mb-3">Rate This Product</h5>
            <div class="d-flex align-items-center mb-3" style="gap: 8px; font-size: 2rem; cursor: pointer;">
                @for ($i = 1; $i <= 5; $i++)
                    <span wire:click="submitRating({{ $i }})"
                        style="color: {{ $i <= $rating ? '#ffc107' : '#e4e5e9' }};">
                        ★
                    </span>
                @endfor
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success py-1 px-2">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Comments -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="mb-3">Add Comment</h5>
            <form wire:submit.prevent="submitComment">
                <div class="mb-3">
                    <textarea class="form-control" wire:model.defer="comment" rows="3" placeholder="Write your comment..."></textarea>
                </div>
                <button class="btn btn-sm btn-primary">Add Comment</button>
            </form>

            <hr>

            <h6>Comments:</h6>
            @foreach ($product->comments as $comm)
                <div class="border rounded p-2 mb-2">
                    <strong>{{ $comm->user->name }}</strong>:
                    <p class="mb-0">{{".....". $comm->comment }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
