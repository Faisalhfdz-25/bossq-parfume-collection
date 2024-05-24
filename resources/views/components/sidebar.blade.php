<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">BossQ Parfume</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">BP</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            {{-- <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}"> --}}
            <li class="nav-item dropdown">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">Ecommerce Dashboard</a>
                    </li>
                </ul>
            </li>
            <li class="menu-header">Master</li>
            {{-- <li class="nav-item dropdown {{ $type_menu === 'layout' ? 'active' : '' }}"> --}}
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class=" fas fa-regular fa-folder-open"></i></i> <span>Data Master</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('products') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('products.index') }}"><i
                                class=" fas fa-regular fa-bag-shopping"></i></i>Product</a>
                    </li>
                    <li class="{{ Request::is('categories') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('categories.index') }}"><i
                                class=" fas fa-solid fa-tags"></i>Category</a>
                    </li>

                    <li class="{{ Request::is('suppliers') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('suppliers.index') }}"><i
                                class="fas fa-solid fa-users-line"></i>Suppliers</a>
                    </li>
                    <li class="{{ Request::is('user*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.index') }}"><i
                                class="fas fa-regular fa-address-card"></i>User</a>
                    </li>




                </ul>
            </li>
            </li>
            <hr width="80%">
            <li class="menu-header">Transaksi</li>
            {{-- <li class="nav-item dropdown {{ $type_menu === 'layout' ? 'active' : '' }}"> --}}
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-solid fa-cash-register"></i></i>
                    <span>Data Transaksi</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('layout-default-layout') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('layout-default-layout') }}"><i
                                class="fas fa-solid fa-hand-holding-dollar"></i>Trasaksi</a>
                    </li>

                </ul>
            </li>
            </li>
            <hr width="80%">
            <li class="menu-header">Laporan</li>
            {{-- <li class="nav-item dropdown {{ $type_menu === 'layout' ? 'active' : '' }}"> --}}
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa-solid fa-file-lines"></i></i>
                    <span>Data Laporan</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('layout-default-layout') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('layout-default-layout') }}">Trasaksi</a>
                    </li>
                </ul>
    </aside>
</div>
