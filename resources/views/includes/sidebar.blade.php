<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('dashboard') }}">
            <img class="img-profile rounded-circle" 
            src="{{ asset('logo-eajm.jpg') }}" 
            alt="Logo EAJM"
            style="width: 60px; height: 60px;">
        <div class="sidebar-brand-text mx-3" style="text-transform: none; font-weight: normal;">Enggar Aji Jaya Mulia</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <!-- Nav Item - Barang Masuk -->
    <li class="nav-item {{ request()->routeIs('product.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('product.index') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Barang Masuk</span>
        </a>
    </li>
    
    <!-- Nav Item - Customer -->
    <li class="nav-item {{ request()->routeIs('customer.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('customer.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Customer</span>
        </a>
    </li>
    
    <!-- Nav Item - Penjualan -->
    <li class="nav-item {{ request()->routeIs('sales.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sales.index') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Penjualan</span>
        </a>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->