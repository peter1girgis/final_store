<div>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
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

                {{-- 📊 Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p class="brand-text">Dashboard</p>
                    </a>
                </li>

                {{-- 🧾 Seller Requests --}}
                <li class="nav-item">
                    <a href="{{ route('admin.seller_requests') }}" class="nav-link {{ request()->is('admin/seller_requests') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p class="brand-text">Seller Requests</p>
                    </a>
                </li>

                {{-- 👥 Users --}}
                <li class="nav-item">
                    <a href="{{ route('admin.users') }}" class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p class="brand-text">Users</p>
                    </a>
                </li>

                {{-- 🏬 Stores --}}
                <li class="nav-item">
                    <a href="{{ route('admin.stores') }}" class="nav-link {{ request()->is('admin/stores') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-store"></i>
                        <p class="brand-text">Stores</p>
                    </a>
                </li>

                {{-- 👤 Profile --}}

                <li class="nav-item">
                    <a href="{{ route('admin.payments') }}" class="nav-link {{ request()->is('admin/payments') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <strong class="brand-text">Payments</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.manageOrders') }}" class="nav-link {{ request()->is('admin/manageOrders') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-cogs"></i>
                        <strong class="brand-text">Orders</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories') }}" class="nav-link {{ request()->is('admin/categories') ? 'active' : '' }} ">
                        <i class="nav-icon fas fa-tags"></i>
                        <strong class="brand-text">Categories</strong>
                    </a>
                </li>

                {{-- ⚙️ Settings --}}
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p class="brand-text">Control Profile</p>
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
