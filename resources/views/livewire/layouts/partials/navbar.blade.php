<div>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link" wire:click="contact">Contact</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3" wire:submit.prevent="search_for_products">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" wire:model="search" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->

        <!-- Notifications Dropdown Menu -->
        <livewire:cart-item-quantity-sum />


        <livewire:layouts.notification-count />
    </ul>
    </nav>
    <div class="modal fade" id="search_model" tabindex="-1" role="dialog"
     aria-labelledby="sendNotificationLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document" style="max-width: 90%;">
        <div class="modal-content  p-3">
            <div class="card p-3 mb-3">
                <form class="form-inline w-100" wire:submit.prevent="search_for_products">
                    <div class="input-group" style="width: 75%;">
                        <input class="form-control form-control-lg" wire:model="search" type="search" placeholder="Search for products..." aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="mb-3">
                    <label class="mb-2 font-weight-bold">Filter by Category:</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($categories as $category)
                            <input type="checkbox" class="btn-check"
                                id="cat-{{ $category->id }}"
                                wire:click="toggleCategory({{ $category->id }})"
                                @if(in_array($category->id, $selectedCategories)) checked @endif
                                autocomplete="off">
                            <label class="btn btn-outline-primary btn-sm" for="cat-{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>


            @if(!empty($results))
                <div class="row">
                    @foreach($results as $product)
                        <div class="col-md-12 mb-4">
                            <div class="card shadow p-3">
                                <div class="row no-gutters align-items-center">

                                    {{-- ✅ Left: Main Product Image (2/3 width) --}}
                                    <div class="col-md-6 pr-3">
                                        <img src="{{ asset('storage/' . $product['main_image']) }}"
                                            class="img-fluid w-100 rounded border shadow-sm"
                                            style="height: 350px; object-fit: contain;" alt="Main Image">
                                    </div>

                                    {{-- ✅ Right: Product Info (1/3 width) --}}
                                    <div class="col-md-6">
                                        <div class="card-body">

                                            <h3 class="card-title mb-2"> <strong  style=" color: rgb(0, 4, 111);">Name : </strong> {{ $product['name'] }}</h3>

                                            <p class="card-text text-muted mb-2" style="max-height: 150px; overflow-y: auto;">
                                                <strong style=" color: rgb(0, 4, 111);">description : </strong>
                                                {{ $product['description'] }}
                                            </p>

                                            <p class="card-text text-success font-weight-bold">
                                                <strong  style=" color: rgb(0, 4, 111);">price : </strong>
                                                {{ $product['price'] }} EGP
                                            </p>

                                            @if($product['old_price'])
                                                <p class="card-text text-muted">
                                                    <strong  style=" color: rgb(0, 4, 111);">old_price : </strong>
                                                    <del>{{ $product['old_price'] }} EGP</del>
                                                </p>
                                            @endif

                                            <p class="card-text mb-2"><strong  style=" color: rgb(0, 4, 111);">stock : </strong> {{ $product['stock'] }}</p>

                                            {{-- ✅ Sub Images as thumbnails with hover zoom --}}
                                            @if($product['sub_images'])
                                                <label class="d-block mt-6"><strong  style=" color: rgb(0, 4, 111);">Other Images</strong></label>

                                                <div class="w-100 d-flex overflow-auto border rounded bg-white px-3 py-2" style="gap: 16px;">
                                                    @foreach(json_decode($product['sub_images'], true) as $sub)
                                                        <div class="flex-shrink-0">
                                                            <img src="{{ asset('storage/' . $sub) }}"
                                                                class="border rounded shadow-sm"
                                                                style="height: 220px; object-fit: contain; transition: transform 0.2s;"
                                                                onmouseover="this.style.transform='scale(1.4)'"
                                                                onmouseout="this.style.transform='scale(1)'"
                                                                alt="Sub Image">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif



                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
<div class="modal fade" id="sendadminNotificationModal" tabindex="-1" role="dialog" aria-labelledby="sendNotificationLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="submitAdminNotification">
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
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane mr-1"></i> Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>
