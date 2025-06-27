<div>
    <aside class="main-sidebar elevation-5" style="background-color: #fefc84; color: rgb(0, 0, 0);">


    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">ٍStoreLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="" class="d-block">{{ auth()->user()->name}}</a>
        </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- ➕ Add Product --}}
                <li class="nav-item">
                    <a href="{{ route('addproduct') }}" class="nav-link {{ request()->is('seller/Add-products') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-plus-square"></i>
                        <strong class="brand-text">Add Product</strong>
                    </a>
                </li>

                {{-- 🏬 My Store --}}
                <li class="nav-item">
                    <a href="{{ route('seller.MyStore') }}" class="nav-link {{ request()->is('seller/MyStore') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-store-alt"></i>
                        <strong class="brand-text">My Store</strong>
                    </a>
                </li>

                {{-- 🏪 All Stores --}}
                <li class="nav-item">
                    <a href="{{ route('seller.stores') }}" class="nav-link {{ request()->is('seller/stores') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-store"></i>
                        <strong class="brand-text">Stores</strong>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('seller.payments') }}" class="nav-link {{ request()->is('seller/payments') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <strong class="brand-text">Payments</strong>
                    </a>
                </li>

                {{-- 👤 Profile --}}
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <strong class="brand-text">Control Profile</strong>
                    </a>
                </li>

                {{-- 🔓 Logout --}}


            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>
</div>
