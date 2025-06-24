<div style="padding-left: 9px; padding-right: 9px; padding-top: 7px;">
    <div class="row">
        @foreach (@$stores as $store)
            <div class="col-md-6">
                <div class="card card-primary card-outline mb-3">
                    <div class="row no-gutters align-items-center">
                        {{-- Left: Store Logo --}}
                        <div class="col-md-4 d-flex justify-content-center align-items-center p-2">
                            @if (@$store->store_logo)
                                <img src="{{ asset('storage/' . @$store->store_logo) }}"
                                     class="img-fluid rounded border shadow-sm"
                                     style="max-height: 120px; object-fit: contain;" alt="Store Logo">
                            @else
                                <div class="bg-light d-flex justify-content-center align-items-center border"
                                     style="height: 120px; width: 100%;">
                                    <span class="text-muted">No Logo</span>
                                </div>
                            @endif
                        </div>

                        {{-- Right: Info --}}
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title mb-1">{{ @$store->store_name }}</h5>
                                <p class="card-text text-muted mb-1">
                                    {{ \Illuminate\Support\Str::limit($store->store_description, 80) }}
                                </p>
                                <p class="card-text mb-2">
                                    <small class="text-success">
                                        Products: {{ @$store->products()->count() }}
                                    </small>
                                </p>
                                <a href="" wire:click.prevent="show_store({{ $store->id }})" class="text-decoration-none">
                                    <i class="fa-solid fa-eye fa-lg text-primary"></i>
                                </a>
                                <a href="#" wire:click.prevent="send_notification({{ $store->id }})" class="text-decoration-none">
                                    <i class="fa-regular fa-paper-plane fa-lg text-success"></i>
                                </a>
                                {{-- <a href="{{ route('store.show', $store->id) }}" class="btn btn-primary btn-sm">View Store</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="modal fade" id="sendNotificationModal" tabindex="-1" role="dialog" aria-labelledby="sendNotificationLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="submitNotification">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sendNotificationLabel">
                            <i class="fa fa-bell mr-1"></i> Send Notification
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        {{-- Hidden --}}
                        <input type="hidden" wire:model="notificationData.user_id">

                        <div class="form-group">
                            <label><strong>Title</strong></label>
                            <input type="text" class="form-control" wire:model.defer="notificationData.title">
                            @error('notificationData.title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label><strong>Message</strong></label>
                            <textarea class="form-control" wire:model.defer="notificationData.message" rows="4"></textarea>
                            @error('notificationData.message') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label><strong>Type</strong></label>
                            <select class="form-control" wire:model.defer="notificationData.type">
                                <option value="general">General</option>
                                <option value="alert">alert</option>
                                <option value="order">Order</option>
                                <option value="warning">warning</option>
                            </select>
                            @error('notificationData.type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane mr-1"></i> Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="form_show_store" tabindex="-1" role="dialog" aria-labelledby="storeModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="storeModalLabel">
                    <i class="fa fa-store mr-1"></i> Store Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                            <input type="text" class="form-control" wire:model.defer="state.store_name" readonly>
                        </div>
                        <div class="form-group">
                            <label><strong>Description</strong></label>
                            <textarea class="form-control" rows="3" wire:model.defer="state.store_description" readonly></textarea>
                        </div>
                        <div class="form-group">
                            <label><strong>Phone</strong></label>
                            <input type="text" class="form-control" wire:model.defer="state.phone" readonly>
                        </div>
                        <div class="form-group">
                            <label><strong>Address</strong></label>
                            <input type="text" class="form-control" wire:model.defer="state.address" readonly>
                        </div>
                        <div class="form-group">
                            <label><strong>Store Owner</strong></label>
                            <input type="text" class="form-control" value="{{ @$store_owner_name ?? 'N/A' }}" readonly>
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
                                            {{ \Illuminate\Support\Str::limit($product['description'], 40) }}
                                        </p>
                                        <p class="text-success fw-bold mb-0" style="font-size: 13px;">
                                            {{ @$product['price'] }} EGP
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
            </div>

        </div>
    </div>
</div>


</div>
