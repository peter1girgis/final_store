<div>
    {{-- Header with Breadcrumb --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $mainCategory->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">{{ $mainCategory->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Scrollable Categories --}}
    <div class="row px-3">
        <div class="position-relative bg-light py-2" style="overflow: hidden;">
            <div id="categoryScroll" class="d-flex gap-3 px-5"
                style="overflow-x: auto; scroll-behavior: smooth; white-space: nowrap;">
                @foreach ($categories as $cat)
                    <div class="card text-center px-3 py-2" style="min-width: 170px; cursor: pointer;">
                        <img src="{{ $cat->image ? asset('storage/' . $cat->image) : '' }}"
                            class="card-img-top rounded-circle border"
                            style="height: 80px; width: 80px; object-fit: cover;" alt="{{ $cat->name }}">
                        <div class="card-body p-1">
                            <small class="text-muted">{{ $cat->name }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Products --}}
        @foreach ($products as $product)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="row no-gutters">
                        <div class="col-4">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img h-100" alt="{{ $product->name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p class="text-success fw-bold mb-2">{{ $product->price }} EGP</p>
                                <a href="#" class="btn btn-sm btn-outline-primary" wire:click.prevent="view_item({{ $product->id }})">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div>{{ $products->links() }}</div>

        {{-- Top Rated Products --}}
        <div class="container py-4">
            <h4 class="mb-4">🔥 Top Rated Products</h4>
            <div class="row">
                @foreach ($topRatedProducts as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow h-100">
                            <img src="{{ asset('storage/' . $product->main_image) }}"
                                class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p><strong>Rating:</strong> ⭐ {{ number_format($product->evaluations_avg_rating, 1) }}/5</p>
                                <a href="#" class="btn btn-sm btn-outline-primary" wire:click.prevent="view_item({{ $product->id }})">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Best Selling Products --}}
        <div class="container py-4">
            <h4 class="mb-4">🔥 Best Selling Products</h4>
            <div class="row">
                @forelse ($topSellingProducts as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow h-100">
                            <img src="{{ asset('storage/' . $product->main_image) }}"
                                class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p><strong>Price:</strong> {{ $product->price }} EGP</p>
                                <a href="#" class="btn btn-sm btn-outline-primary" wire:click.prevent="view_item({{ $product->id }})">View</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No sales data available.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
