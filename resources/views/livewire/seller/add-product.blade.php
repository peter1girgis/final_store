<div>
    {{-- <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

        <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end mb-2">
                    <button wire:click.prevent="addNewProduct" class="btn btn-primary"><i class="fa fa-plus-circle mr-1"></i> Add New Product</button>
                </div>
            <div class="card">
                <div class="card-body">
                    <h1>
                        //
                    </h1>
                </div>
            </div>
            </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div> --}}
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
    <div class="content">
        <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end mb-2">
                    <button wire:click.prevent="addNewProduct" class="btn btn-outline-primary"><i class="fa fa-plus-circle mr-1"></i> Add New Product</button>
                </div>
            </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="row px-3">
        @foreach ($products as $product)
            <div class="col-md-6 mb-4">
                <div class="card h-100 position-relative"> {{-- نضيف position-relative هنا --}}

                    {{-- شارة Out of Stock --}}
                    @if (!$product->is_active || $product->stock == 0)
                        <div class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end" style="z-index: 10;">
                            Out of Stock
                        </div>
                    @endif

                    <div class="row no-gutters">

                        <!-- الجزء الخاص بالصورة -->
                        <div class="col-4">
                            @if(@$product->main_image)
                                <img src="{{ asset('storage/' . @$product->main_image) }}" class="card-img h-100" alt="{{ $product->name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                    No Image
                                </div>
                            @endif
                        </div>

                        <!-- الجزء الخاص بالمحتوى -->
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ @$product->name }}</h5>
                                <p class="card-text">{{ Str::limit(@$product->description, 100) }}</p>
                                <p class="text-success fw-bold mb-2">{{ @$product->price }} EGP</p>
                                <a href="" class="btn btn-sm btn-outline-primary" wire:click.prevent="view_item({{ $product->id ?? '' }})">View</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach

        <div>
            {{ $products->links() }} {{-- ✅ --}}
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

                {{-- Start: OUT OF STOCK BADGE --}}
                @if (!@$state['is_active'] || @$state['stock'] == 0)
                    <div class="position-absolute top-0 start-0 bg-danger text-white px-3 py-1 rounded-end" style="z-index: 1050;">
                        Out of Stock
                    </div>
                @endif
                {{-- End: OUT OF STOCK BADGE --}}

                <div class="row position-relative">
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
                            <input type="text" class="form-control" wire:model.defer="state.name">
                        </div>

                        <div class="form-group">
                            <label><strong>Description</strong></label>
                            <textarea class="form-control" rows="4" wire:model.defer="state.description"></textarea>
                        </div>

                        <div class="form-group row">
                            <div class="col">
                                <label><strong>Price</strong></label>
                                <input type="text" class="form-control text-success" wire:model.defer="state.price">
                            </div>
                            <div class="col">
                                <label><strong>Old Price</strong></label>
                                <input type="text" class="form-control text-muted" wire:model.defer="state.old_price">
                            </div>
                            <div class="col">
                                <label><strong>Stock</strong></label>
                                <input type="number" class="form-control {{ @$state['stock'] == 0 ? 'text-danger font-weight-bold' : '' }}"
                                       wire:model.defer="state.stock">
                            </div>

                            {{-- Category Selector --}}
                            <div class="form-group mt-3">
                                <label><strong>Select Categories</strong></label>
                                <select class="form-control" wire:change="addCategory($event.target.value)">
                                    <option value="">-- Choose Category --</option>
                                    @foreach (@$all_categories as $category)
                                        @if (!in_array($category->id, @$selected_categories))
                                            <option value="{{ @$category->id }}">{{ @$category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                {{-- Display selected categories --}}
                                <div class="d-flex flex-wrap mt-2" style="gap: 10px;">
                                    @foreach (@$selected_categories as $catId)
                                        @php
                                            @$catName = @$all_categories->firstWhere('id', $catId)?->name;
                                        @endphp
                                        <div class="badge badge-primary d-flex align-items-center">
                                            <span>{{ @$catName }}</span>
                                            <button type="button" class="ml-2 btn btn-sm btn-danger btn-circle" wire:click="removeCategory({{ $catId }})" style="padding: 0 5px; margin-left: 5px;">
                                                &times;
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
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
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fa fa-times mr-1"></i> Close
                </button>
                <button type="button" wire:click="save_changes" class="btn btn-outline-success">
                    <i class="fa fa-save mr-1"></i> Save changes
                </button>
            </div>

        </div>
    </div>
</div>

    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addProductLabel">
                    <i class="fa fa-box-open mr-1"></i> Add New Product
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form wire:submit.prevent="submitProduct" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        {{-- Main Image --}}
                        <div class="col-md-4 mb-3">
                            @if (@$main_image)
                                <img src="{{ @$main_image->temporaryUrl() }}" class="img-fluid rounded border shadow-sm" style="max-height: 300px; object-fit: contain;" alt="Main Image Preview">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center border" style="height: 300px;">
                                    <span class="text-muted">No Main Image</span>
                                </div>
                            @endif

                            <div class="mt-3">
                                <label><strong>Main Image</strong></label>
                                <input type="file" wire:model="main_image" class="form-control-file">
                                @error('main_image') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- Product Info --}}
                        <div class="col-md-8">
                            <div class="form-group">
                                <label><strong>Product Name</strong></label>
                                <input type="text" class="form-control" wire:model.defer="state.name">
                                @error('state.name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label><strong>Description</strong></label>
                                <textarea class="form-control" rows="3" wire:model.defer="state.description"></textarea>
                                @error('state.description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label><strong>Price</strong></label>
                                    <input type="number" class="form-control" wire:model.defer="state.price" step="0.01">
                                    @error('state.price') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col">
                                    <label><strong>Old Price (Optional)</strong></label>
                                    <input type="number" class="form-control" wire:model.defer="state.old_price" step="0.01">
                                    @error('state.old_price') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col">
                                    <label><strong>Stock</strong></label>
                                    <input type="number" class="form-control" wire:model.defer="state.stock">
                                    @error('state.stock') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <label><strong>Select Categories</strong></label>
                                    <select class="form-control" wire:change="addCategory($event.target.value)">
                                        <option value="">-- Choose Category --</option>
                                        @foreach (@$all_categories as $category)
                                            @if (!in_array(@$category->id, @$selected_categories))
                                                <option value="{{ @$category->id }}">{{ @$category->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    {{-- Display selected categories --}}
                                    <div class="d-flex flex-wrap mt-2" style="gap: 10px;">
                                        @foreach (@$selected_categories as $catId)
                                            @php
                                                @$catName = @$all_categories->firstWhere('id', $catId)?->name;
                                            @endphp
                                            <div class="badge badge-primary d-flex align-items-center">
                                                <span>{{ @$catName }}</span>
                                                <button type="button" class="ml-2 btn btn-sm btn-danger btn-circle" wire:click="removeCategory({{ $catId }})" style="padding: 0 5px; margin-left: 5px;">
                                                    &times;
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                            {{-- Store Selector --}}
                        </div>
                    </div>

                    {{-- Sub Images --}}
                    <div class="form-group mt-3">
                        <label><strong>Upload Sub Images</strong></label>
                        <input type="file" multiple wire:model="sub_images" class="form-control-file">
                        @error('sub_images.*') <span class="text-danger">{{ $message }}</span> @enderror

                        @if ($sub_images)
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                @foreach (@$sub_images as $img)
                                    <img src="{{ @$img->temporaryUrl() }}" class="rounded border" style="height: 100px; object-fit: contain;">
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fa fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-outline-success">
                        <i class="fa fa-save mr-1"></i> Save Product
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

</div>
