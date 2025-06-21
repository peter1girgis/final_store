<div>
        <aside class="main-sidebar elevation-5" style="background-color: #28345c; color: rgb(0, 0, 0);">


    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
        </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
            <a href="{{ route('user.product') }}" class="nav-link {{ request()->is('user/products') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <strong>Product</strong>
            </a>
            </li>

            <li class="nav-item">
            <a href="" class="nav-link " wire:click.prevent="show_form_request">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <strong>Become A Seller</strong>
            </a>
            </li>

            <li class="nav-item">
            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <strong>
                Users
                </strong>
            </a>
            </li>

            <li class="nav-item">
                <a href="{{route('profile.edit')}}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <strong>
                    control profile
                    </strong>
                </a>
            </li>

            {{-- <li class="nav-item">
            <a href="{{route('logout')}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <strong>
                Logout
                </strong>
            </a>
            </li> --}}
            <x-dropdown class="nav-item" align="right" width="48">
                    <x-slot name="trigger">
                        <button class="btn btn-navbar" type="submit">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                            <strong>
                                Go To Sitting
                            </strong>
                        </button>

                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>
    <div class="modal fade" id="becomeSellerModal" tabindex="-1" role="dialog" aria-labelledby="becomeSellerLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="becomeSellerLabel">
                        <i class="fa fa-store mr-1"></i> Become a Seller
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form wire:submit.prevent="submitRequest" enctype="multipart/form-data">
                    <div class="modal-body">

                        <div class="row">
                            {{-- Store Logo Preview --}}
                            <div class="col-md-4 mb-3">
                                @if (@$state['store_logo'])
                                    <img src="{{ $state['store_logo']->temporaryUrl() }}"
                                        class="img-fluid rounded border shadow-sm"
                                        style="max-height: 300px; object-fit: contain;"
                                        alt="Store Logo Preview">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center border"
                                        style="height: 300px;">
                                        <span class="text-muted">No Logo</span>
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <label><strong>Upload Store Logo</strong></label>
                                    <input type="file" wire:model="state.store_logo" class="form-control-file">
                                    @error('state.store_logo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Store Info --}}
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label><strong>Store Name</strong></label>
                                    <input type="text" class="form-control" wire:model.defer="state.store_name">
                                    @error('state.store_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label><strong>Description</strong></label>
                                    <textarea class="form-control" rows="3" wire:model.defer="state.store_description"></textarea>
                                    @error('state.store_description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label><strong>Phone</strong></label>
                                    <input type="text" class="form-control" wire:model.defer="state.phone">
                                    @error('state.phone') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label><strong>Address</strong></label>
                                    <input type="text" class="form-control" wire:model.defer="state.address">
                                    @error('state.address') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times mr-1"></i> Close
                        </button>

                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-paper-plane mr-1"></i> Submit Request
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
