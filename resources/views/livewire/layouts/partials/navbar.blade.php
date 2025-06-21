<div>
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
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
        <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="{{ asset('backend/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="{{ asset('backend/dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
                <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
            </div>
            <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
        </li>
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


</div>
