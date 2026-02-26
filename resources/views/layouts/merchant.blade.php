<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Merchant Dashboard')</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ $pengaturan->logo_dark_url ?? asset('assets/images/4S.png') }}">

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Google Material Symbols Rounded -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/merchant-dashboard.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body>

    <!-- Loading Overlay -->
    <div id="loader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Mobile Sidebar Dark Overlay -->
    <div id="mobile-overlay"></div>

    <!-- SIDEBAR NAVIGATION -->
    <aside id="sidebar">
        <div class="brand gs-reveal">
            <div class="logo-icon">
                <span class="material-symbols-rounded" style="font-size: 28px;">food_bank</span>
            </div>
            <span class="brand-text">Catering.</span>
        </div>

        <nav class="nav-menu">
            <div class="nav-label gs-reveal">Overview</div>
            <a href="{{ route('merchant.dashboard') }}" class="nav-item {{ request()->routeIs('merchant.dashboard') ? 'active' : '' }} gs-item">
                <span class="material-symbols-rounded">space_dashboard</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('merchant.menus.index') }}" class="nav-item {{ request()->routeIs('merchant.menus.*') ? 'active' : '' }} gs-item">
                <span class="material-symbols-rounded">restaurant_menu</span>
                <span>Menus & Packages</span>
            </a>

            <!-- Pesanan Masuk -->
            <a href="{{ route('merchant.orders.index') }}" class="nav-item {{ request()->routeIs('merchant.orders.*') ? 'active' : '' }} gs-item">
                <span class="material-symbols-rounded">local_mall</span>
                <span>Pesanan Masuk</span>
            </a>

            <div class="nav-label gs-reveal" style="margin-top: 24px;">Account</div>
            <form action="{{ route('merchant.logout') }}" method="POST" class="gs-item">
                @csrf
                <button type="submit" class="nav-item w-full text-left" style="width: 100%; border: none; background: transparent; cursor: pointer;">
                    <span class="material-symbols-rounded text-red-500">logout</span>
                    <span style="color: #b91c1c;">Logout</span>
                </button>
            </form>
        </nav>

        <div class="sidebar-footer gs-reveal">
            <div class="user-profile-sm">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=EBF4FF&color=1F4A9C" alt="Admin Profile">
                <div class="user-info">
                    <div class="name" style="width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->name }}</div>
                    <div class="role">Merchant</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN LAYOUT -->
    <div id="main-wrapper">

        <!-- Top Navigation -->
        <header id="topbar">
            <div class="topbar-left">
                <!-- Hamburger for mobile -->
                <button class="icon-btn" id="menu-toggle" aria-label="Toggle Menu">
                    <span class="material-symbols-rounded">menu</span>
                </button>

                @yield('topbar-search')
            </div>

            <div class="topbar-right">
                <button class="icon-btn" title="Notifications">
                    <span class="material-symbols-rounded">notifications</span>
                    <span class="indicator"></span>
                </button>
                <div style="width: 1px; height: 24px; background: var(--stone-100); margin: 0 8px;"></div>
                @yield('topbar-actions')
            </div>
        </header>

        <!-- Dynamic Content Area -->
        <main class="content-container">
            @yield('content')
        </main>
    </div>

    <!-- GSAP CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="{{ asset('assets/js/merchant-dashboard.js') }}"></script>
    @stack('scripts')
</body>

</html>