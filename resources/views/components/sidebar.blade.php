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
                <a href=""
                    class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('home') }}">Ecommerce Dashboard</a>
                    </li>
                </ul>
            </li>
            <li class="menu-header">Master</li>
            {{-- <li class="nav-item dropdown {{ $type_menu === 'layout' ? 'active' : '' }}"> --}}
                <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Data Master</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('products') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('products.index') }}">Product</a>
                    </li>
                    
                    <li class="{{ Request::is('transparent-sidebar') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('transparent-sidebar') }}">Category</a>
                    </li>
                    <li class="{{ Request::is('user*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.index') }}">Galleri</a>
                    </li>
                    <li class="{{ Request::is('user*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user.index') }}">User</a>
                    </li>
                    
                    
                    
                    
                </ul>
            </li>
            </li>
            <li class="menu-header">Transaksi</li>
            {{-- <li class="nav-item dropdown {{ $type_menu === 'layout' ? 'active' : '' }}"> --}}
                <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Data Transaksi</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('layout-default-layout') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('layout-default-layout') }}">Trasaksi</a>
                    </li>
                    <li class="{{ Request::is('transparent-sidebar') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('transparent-sidebar') }}">Category</a>
                    </li>
                </ul>
            </li>
            </li>
            <li class="menu-header">Laporan</li>
                    {{-- <li class="nav-item dropdown {{ $type_menu === 'layout' ? 'active' : '' }}"> --}}
                        <li class="nav-item dropdown">
                        <a href="#"
                            class="nav-link has-dropdown"
                            data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Data Laporan</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ Request::is('layout-default-layout') ? 'active' : '' }}">
                                <a class="nav-link"
                                    href="{{ url('layout-default-layout') }}">Trasaksi</a>
                            </li>
                            <li class="{{ Request::is('transparent-sidebar') ? 'active' : '' }}">
                                <a class="nav-link"
                                    href="{{ url('transparent-sidebar') }}">Category</a>
                            </li>






           {{-- <li class="menu-header">Landing Pages</li> --}}
           
                {{-- <li class="nav-item dropdown"> --}}
                {{-- <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-th-large"></i>
                    <span>Components</span></a> --}}
                {{-- <ul class="dropdown-menu"> --}}
                    {{-- <li class="{{ Request::is('landing-pages') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('landing_pages.index') }}">Main Content</a>
                    </li> --}}
                    {{-- <li class="{{ Request::is('components-avatar') ? 'active' : '' }}">
                        <a class="nav-link beep beep-sidebar"
                            href="{{ url('components-avatar') }}">Content</a>
                    </li> --}}
                    {{-- <li class="{{ Request::is('components-chat-box') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('components-chat-box') }}">Banner</a>
                    </li> --}}
                    {{-- <li class="{{ Request::is('components-empty-state') ? 'active' : '' }}">
                        <a class="nav-link beep beep-sidebar"
                            href="{{ url('components-empty-state') }}">Single Photo</a>
                    </li>
                    <li class="{{ Request::is('components-gallery') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('components-gallery') }}">Gallery</a>
                    </li>
                    <li class="{{ Request::is('components-hero') ? 'active' : '' }}">
                        <a class="nav-link beep beep-sidebar"
                            href="{{ url('components-hero') }}">Hero</a> --}}
                    {{-- </li>
                </ul> --}}
            {{-- </li> --}}
          
            
            
            
            
            
           
           
        </ul>

    </aside>
</div>
