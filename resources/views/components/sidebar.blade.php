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
            <li class="menu-header">Starter</li>
            {{-- <li class="nav-item dropdown {{ $type_menu === 'layout' ? 'active' : '' }}"> --}}
                <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('layout-default-layout') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('layout-default-layout') }}">Default Layout</a>
                    </li>
                    <li class="{{ Request::is('transparent-sidebar') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('transparent-sidebar') }}">Transparent Sidebar</a>
                    </li>
                    <li class="{{ Request::is('layout-top-navigation') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('layout-top-navigation') }}">Top Navigation</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="far fa-square"></i> <span>Blank Page</span></a>
            </li>
            </li>
            <li class="menu-header">Landing Pages</li>
            {{-- <li class="nav-item dropdown {{ $type_menu === 'components' ? 'active' : '' }}"> --}}
                <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-th-large"></i>
                    <span>Components</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('landing-pages') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('landing_pages.index') }}">Main Content</a>
                    </li>
                    <li class="{{ Request::is('components-avatar') ? 'active' : '' }}">
                        <a class="nav-link beep beep-sidebar"
                            href="{{ url('components-avatar') }}">Content</a>
                    </li>
                    <li class="{{ Request::is('components-chat-box') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('components-chat-box') }}">Banner</a>
                    </li>
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
                    </li>
                </ul>
            </li>
          
            
            
            
            
            
           
           
        </ul>

    </aside>
</div>
