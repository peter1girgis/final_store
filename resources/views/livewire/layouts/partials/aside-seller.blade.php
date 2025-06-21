<div>
    <aside class="main-sidebar elevation-5" style="background-color: #fefc84; color: rgb(0, 0, 0);">


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
            <a href="#" class="d-block">{{ auth()->user()->name}}</a>
        </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
            <a href="{{ route('addproduct') }}" class="nav-link {{ request()->is('seller/Add-products') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <strong>Add Product</strong>
            </a>
            </li>
            <li class="nav-item">
            <a href="{{ route('seller.MyStore') }}" class="nav-link {{ request()->is('seller/MyStore') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <strong>
                My Store
                </strong>
            </a>
            </li>
            <li class="nav-item">
            <a href="{{ route('seller.stores')}}" class="nav-link {{ request()->is('seller/stores') ? 'active' : '' }}">
                <i class="nav-icon fa fa-store mr-1"></i></i>
                <strong>
                Stores
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

            <li class="nav-item">
            <a href="{{route('logout')}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <strong>
                Logout
                </strong>
            </a>
            </li>
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>
</div>
