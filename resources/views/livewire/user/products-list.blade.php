<div>
    <!-- Content Header -->
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
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="row px-3">
        <div class="position-relative bg-light py-2" style="overflow: hidden;">

            <!-- LEFT ARROW -->
            {{-- <button onclick="scrollLeft()"
                    class="btn btn-light position-absolute start-0 z-10 shadow"
                    style="top: 50%; transform: translateY(-50%); height: 60px; width: 40px;">
                <i class="fas fa-chevron-left"></i>
            </button> --}}

            <!-- CATEGORY SCROLL CONTAINER -->
            <div id="categoryScroll" class="d-flex gap-3 px-5"
                style="overflow-x: auto; scroll-behavior: smooth; white-space: nowrap;">
                @foreach ($categories as $cat)
                    <div class="card text-center px-3 py-2" style="min-width: 170px; cursor: pointer;" style="justify-items: center;">
                        <img src="{{ asset('storage/' . $cat->image) }}"
                            class="card-img-top rounded-circle border"
                            style="height: 80px; width: 80px; object-fit: cover; " alt="{{ $cat->name }}">
                        <div class="card-body p-1">
                            <small class="text-muted">{{ $cat->name }}</small>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- RIGHT ARROW -->
            {{-- <button onclick="scrollRight()"
                    class="btn btn-light position-absolute end-0 z-10 shadow"
                    style="top: 50%; transform: translateY(-50%); height: 60px; width: 40px;">
                <i class="fas fa-chevron-right"></i>
            </button> --}}

        </div>




        @foreach ($products as $product)
            <div class="col-md-6 mb-4">
                {{-- ✅ تأكد إن الكرت فيه position-relative --}}
                <div class="card h-100 position-relative overflow-hidden">

                    {{-- ✅ شريط "Out of Stock" --}}
                    @if (!$product->is_active)
                        <div style="position: absolute; top: 0; left: 0; z-index: 10;"
                            class="bg-danger text-white px-2 py-1 rounded-end">
                            Out of Stock
                        </div>
                    @endif

                    <div class="row g-0">
                        <div class="col-4">
                            @if ($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" class="img-fluid h-100 object-fit-cover" alt="{{ $product->name }}">
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
                                <a href="#" class="btn btn-sm btn-outline-primary"
                                    wire:click.prevent="view_item({{ $product->id }})">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
        <div>
            {{ $products->links() }}
        </div>
        <div class="container py-4">
            <h4 class="mb-4">🔥 Top Rated Products</h4>
            <div class="row">
                @foreach ($topRatedProducts as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow h-100 position-relative">
                            {{-- ✅ شريط Out of Stock --}}
                            @if (!$product->is_active)
                                <div class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end">
                                    Out of Stock
                                </div>
                            @endif

                            <img src="{{ asset('storage/' . $product->main_image) }}"
                                class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p><strong>Rating:</strong> ⭐ {{ number_format($product->evaluations_avg_rating, 1) }}/5</p>

                                <a href="#" class="btn btn-sm btn-outline-primary"
                                    wire:click.prevent="view_item({{ $product->id }})">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        <div class="container py-4">
            <h4 class="mb-4">🔥 Best Selling Products</h4>
            <div class="row">
                @forelse ($topSellingProducts as $product)
                    <div class="col-md-4 mb-4">
                        {{-- لازم تخلي الكارت position-relative عشان الشريط يظهر صح --}}
                        <div class="card shadow h-100 position-relative overflow-hidden">

                            {{-- ✅ شريط Out of Stock --}}
                            @if (!$product->is_active)
                                <div class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end"
                                    style="z-index: 10;">
                                    Out of Stock
                                </div>
                            @endif

                            <img src="{{ asset('storage/' . $product->main_image) }}"
                                class="card-img-top" style="height: 200px; object-fit: cover;">

                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p><strong>Price:</strong> {{ $product->price }} EGP</p>
                                <a href="#" class="btn btn-sm btn-outline-primary"
                                    wire:click.prevent="view_item({{ $product->id }})">View</a>
                            </div>

                        </div>
                    </div>
                @empty
                    <p>No sales data available.</p>
                @endforelse
            </div>
        </div>

    </div>



    <div class="modal fade" id="show_product" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">
                    <i class="fa fa-box mr-1"></i> Product Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                {{-- 🔴 تنبيه حالة Out of Stock --}}
                @if (isset($state['stock']) && $state['stock'] == 0 || !@$state['is_active'])
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>This product is currently out of stock.</strong>
                    </div>
                @endif

                <div class="row">
                    {{-- Main Image --}}
                    <div class="col-md-4">
                        @if (!empty(@$state['main_image']))
                            <img src="{{ asset('storage/' . @$state['main_image']) }}"
                                 class="img-fluid rounded shadow-sm border w-100"
                                 style="max-height: 300px; object-fit: contain;"
                                 alt="Main Image">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center border"
                                 style="height: 300px;">
                                <span class="text-muted">No Image</span>
                            </div>
                        @endif
                    </div>

                    {{-- Product Info --}}
                    <div class="col-md-8">
                        <div class="form-group">
                            <label><strong>Product Name</strong></label>
                            <input type="text" class="form-control" wire:model.defer="state.name" readonly>
                        </div>

                        <div class="form-group">
                            <label><strong>Description</strong></label>
                            <textarea class="form-control" rows="4" wire:model.defer="state.description" readonly></textarea>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label><strong>Price</strong></label>
                                <input type="text" class="form-control text-success" wire:model.defer="state.price" readonly>
                            </div>
                            <div class="col">
                                <label><strong>Old Price</strong></label>
                                <input type="text" class="form-control text-muted" wire:model.defer="state.old_price" readonly>
                            </div>
                            <div class="col">
                                <label><strong>Stock</strong></label>
                                <input type="number"
                                       class="form-control {{ (isset($state['stock']) && $state['stock'] == 0) ? 'text-danger font-weight-bold' : '' }}"
                                       wire:model.defer="state.stock"
                                       readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Categories --}}
                    <div class="form-group mt-3">
                        <label><strong>Categories</strong></label>
                        <div class="d-flex flex-wrap mt-2" style="gap: 10px;">
                            @if (count(@$selected_categories) >= 1)
                                @foreach (@$selected_categories as $catId)
                                    @php
                                        $catName = collect($all_categories)->firstWhere('id', $catId)?->name;
                                    @endphp
                                    <span class="badge badge-info px-3 py-2">
                                        {{ $catName }}
                                    </span>
                                @endforeach
                            @else
                                <span style="color: rgb(192, 255, 83)" class="badge badge-info px-3 py-2">
                                    no categories found related to this item
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sub Images --}}
                @if (!empty($state['sub_images']) && is_array($state['sub_images']) && count($state['sub_images']) > 0)
                    <div class="mt-4">
                        <label><strong>Other Images</strong></label>
                        <div class="d-flex overflow-auto" style="gap: 10px;">
                            @foreach (@$state['sub_images'] as $img)
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . @$img) }}"
                                         class="rounded border"
                                         style="height: 190px; width: auto; object-fit: contain;"
                                         alt="Sub Image">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm btn-outline-primary"
                        wire:click="addToCart({{ @$state['id']}})"
                        @if (empty($state['stock']) || $state['stock'] == 0 || !$state['is_active']) disabled @endif>
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>

                @if (!empty($state['id']))
                    <a href="{{ route('product.show', $state['id']) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> More Details
                    </a>
                @endif

                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fa fa-times mr-1"></i> Close
                </button>
            </div>

        </div>
    </div>
</div>



    <!-- /.content -->
</div>
