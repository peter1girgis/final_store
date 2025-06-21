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
            <a href="#" class="d-block">Alexander Pierce</a>
        </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
            <a href="{{ route('user.product') }}" class="nav-link {{ request()->is('seller/Add-products') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <strong>Add Product</strong>
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
