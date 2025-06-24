<div class=" modal-x2" role="document">


            <div class="modal-header">
                <h5 class="modal-title" id="storeModalLabel">
                    <i class="fa fa-store mr-1"></i> Store Details
                </h5>

            </div>

            <div class="modal-body">
                {{-- بيانات المتجر --}}
                <div class="row mb-4">
                    {{-- شعار المتجر --}}
                    <div class="col-md-4 mb-3">
                        @if (!empty(@$state['store_logo']))
                            <img src="{{ asset('storage/' . @$state['store_logo']) }}"
                                class="img-fluid rounded border shadow-sm w-100"
                                style="max-height: 300px; object-fit: contain;"
                                alt="Store Logo">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center border" style="height: 300px;">
                                <span class="text-muted">No Logo</span>
                            </div>
                        @endif
                    </div>

                    {{-- معلومات المتجر --}}
                    <div class="col-md-8">
                        <div class="form-group">
                            <label><strong>Store Name</strong></label>
                            <input type="text" class="form-control" wire:model.defer="state.store_name" >
                        </div>
                        <div class="form-group">
                            <label><strong>Description</strong></label>
                            <textarea class="form-control" rows="3" wire:model.defer="state.store_description" ></textarea>
                        </div>
                        <div class="form-group">
                            <label><strong>Phone</strong></label>
                            <input type="text" class="form-control" wire:model.defer="state.phone" >
                        </div>
                        <div class="form-group">
                            <label><strong>Address</strong></label>
                            <input type="text" class="form-control" wire:model.defer="state.address" >
                        </div>
                        <div class="form-group">
                            <label><strong>Store Owner</strong></label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                        </div>
                    </div>
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="far fa-bookmark"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Products</span>
                            <span class="info-box-number">{{ @$product_count }}</span>
                            <div class="progress">
                            <div class="progress-bar bg-info" style="width: 70%"></div>
                            </div>
                            {{-- <span class="progress-description">
                            70% Increase in 30 Days
                            </span> --}}
                        </div>
                    </div>
                </div>

                {{-- منتجات المتجر --}}
                @if (!empty(@$store_products) && count(@$store_products) > 0)
                    <div>
                        <label><strong>Store Products</strong></label>
                        <div class="d-flex overflow-auto" style="gap: 15px;">
                            @foreach (@$store_products as $product)
                                <div class="card flex-shrink-0" style="width: 180px;">
                                    @if ($product['main_image'])
                                        <img src="{{ asset('storage/' . @$product['main_image']) }}" class="card-img-top" style="height: 130px; object-fit: cover;" alt="Product Image">
                                    @else
                                        <div class="bg-light d-flex justify-content-center align-items-center" style="height: 130px;">
                                            <span class="text-muted">No Image</span>
                                        </div>
                                    @endif
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1" style="font-size: 14px;">{{ \Illuminate\Support\Str::limit(@$product['name'], 20) }}</h6>
                                        <p class="card-text text-muted" style="font-size: 12px;">
                                            {{ \Illuminate\Support\Str::limit(@$product['description'], 40) }}
                                        </p>
                                        <p class="text-success fw-bold mb-0" style="font-size: 13px;">
                                            {{ $product['price'] }} EGP
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times mr-1"></i> Close
                </button>
                <button type="button" wire:click = "save_changes"  class="btn btn-success">
                        <i class="fa fa-save mr-1"></i> Save changes
                </button>
            </div>


    </div>
