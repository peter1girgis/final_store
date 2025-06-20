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
        @foreach ($products as $product)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="row no-gutters">

                        <!-- الجزء الخاص بالصورة -->
                        <div class="col-4">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" class="card-img h-100" alt="{{ $product->name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                    No Image
                                </div>
                            @endif
                        </div>

                        <!-- الجزء الخاص بالمحتوى -->
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p class="text-success fw-bold mb-2">{{ $product->price }} EGP</p>
                                <a href="" class="btn btn-sm btn-primary" wire:click.prevent="view_item({{ $product->id ?? '' }})">View</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="show_product" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document"> {{-- أكبر عرض ممكن --}}
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
                <div class="row">
                    {{-- Main Image --}}
                    <div class="col-md-4">
                        @if (!empty($state['main_image']))
                            <img src="{{ asset('storage/' . $state['main_image']) }}"
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
                                <input type="number" class="form-control" wire:model.defer="state.stock" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sub Images --}}
                @if (!empty($state['sub_images']) && is_array($state['sub_images']) && count($state['sub_images']) > 0)
                    <div class="mt-4">
                        <label><strong>Other Images</strong></label>
                        <div class="d-flex flex-wrap gap-3 overflow-auto">
                            @foreach ($state['sub_images'] as $img)
                                <img src="{{ asset('storage/' . $img) }}"
                                     class="rounded border"
                                     style="height: 300px; width: auto; object-fit: contain;"
                                     alt="Sub Image">
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times mr-1"></i> Close
                </button>
            </div>

        </div>
    </div>
</div>



    <!-- /.content -->
</div>
