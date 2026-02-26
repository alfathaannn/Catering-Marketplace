<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Customer Catering Marketplace')</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ $pengaturan->logo_dark_url ?? asset('assets/images/4S.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Top Navbar */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: white;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 50;
        }

        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f4a9c;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .nav-link {
            color: #475569;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #1f4a9c;
        }

        .logout-btn {
            background: none;
            border: none;
            color: #ef4444;
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            transition: color 0.2s;
            padding: 0;
        }

        .logout-btn:hover {
            color: #dc2626;
        }

        /* Main Content */
        .main-content {
            margin-top: 70px;
            /* offset for top navbar */
            min-height: calc(100vh - 70px);
            padding: 32px;
        }

        /* Profile Simulation */
        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #1f4a9c;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Mobile Sidebar and Hamburger */
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            color: #475569;
            cursor: pointer;
            padding: 8px;
            margin-right: 8px;
        }

        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            background: white;
            z-index: 100;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .mobile-sidebar.open {
            transform: translateX(0);
        }

        .mobile-sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 90;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .mobile-sidebar-backdrop.open {
            opacity: 1;
            pointer-events: auto;
        }

        .mobile-nav-links {
            padding: 24px 0;
            flex-grow: 1;
        }

        .mobile-nav-link {
            display: flex;
            align-items: center;
            padding: 16px 24px;
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            border-left: 3px solid transparent;
        }

        .mobile-nav-link.active,
        .mobile-nav-link:hover {
            color: #1f4a9c;
            background: #f1f5f9;
            border-left-color: #1f4a9c;
        }

        /* Profile Dropdown */
        .profile-dropdown-container {
            position: relative;
        }

        .profile-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            width: 220px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            z-index: 60;
            transform-origin: top right;
        }

        .profile-dropdown-header {
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .profile-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #475569;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
            cursor: pointer;
            width: 100%;
            text-align: left;
            border: none;
            background: none;
        }

        .profile-dropdown-item:hover {
            background: #f1f5f9;
            color: #1f4a9c;
        }

        .profile-dropdown-item.danger {
            color: #ef4444;
        }

        .profile-dropdown-item.danger:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hamburger-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .main-content {
                padding: 16px;
            }
        }
    </style>
</head>

<body x-data="{ mobileMenuOpen: false }">

    <!-- Top Navbar -->
    <nav class="top-navbar">
        <div style="display: flex; align-items: center;">
            <button @click="mobileMenuOpen = true" class="hamburger-btn">
                <span class="material-symbols-rounded">menu</span>
            </button>
            <a href="{{ route('customer.dashboard') }}" class="navbar-brand">
                CM
            </a>
        </div>

        <div class="nav-right">
            <div class="nav-links">
                <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('customer.orders.index') }}" class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}">History</a>
            </div>

            <!-- Profile Dropdown Container -->
            <div class="profile-dropdown-container" x-data="{ profileMenuOpen: false }">
                <div class="user-profile" title="{{ Auth::user()->name }}" @click="profileMenuOpen = !profileMenuOpen" @click.away="profileMenuOpen = false">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>

                <!-- Dropdown Menu -->
                <div x-show="profileMenuOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="profile-dropdown"
                    style="display: none;"
                    x-cloak>

                    <div class="profile-dropdown-header">
                        <div style="font-weight: 600; color: #0f172a; margin-bottom: 2px;">{{ Auth::user()->name }}</div>
                        <div style="font-size: 0.75rem; color: #64748b;">{{ Auth::user()->email }}</div>
                    </div>

                    <a href="#" class="profile-dropdown-item">
                        <span class="material-symbols-rounded" style="font-size: 18px;">manage_accounts</span>
                        Pengaturan Akun
                    </a>
                    <a href="#" class="profile-dropdown-item">
                        <span class="material-symbols-rounded" style="font-size: 18px;">storefront</span>
                        Pengaturan Profil
                    </a>

                    <div style="height: 1px; background: #e2e8f0; margin: 4px 0;"></div>

                    <form action="{{ route('customer.logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="profile-dropdown-item danger">
                            <span class="material-symbols-rounded" style="font-size: 18px;">logout</span>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar Backdrop -->
    <div class="mobile-sidebar-backdrop" :class="mobileMenuOpen ? 'open' : ''" @click="mobileMenuOpen = false"></div>

    <!-- Mobile Sidebar -->
    <div class="mobile-sidebar" :class="mobileMenuOpen ? 'open' : ''">
        <div style="padding: 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <div style="font-weight: 700; color: #1f4a9c; display: flex; align-items: center; gap: 8px;">
                CM
            </div>
            <button @click="mobileMenuOpen = false" style="background: none; border: none; color: #64748b; cursor: pointer;">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>

        <div class="mobile-nav-links">
            <a href="{{ route('customer.dashboard') }}" class="mobile-nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                <span class="material-symbols-rounded" style="margin-right: 12px;">dashboard</span>
                Dashboard
            </a>
            <a href="{{ route('customer.orders.index') }}" class="mobile-nav-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}">
                <span class="material-symbols-rounded" style="margin-right: 12px;">receipt_long</span>
                History
            </a>
        </div>

        <div style="padding: 24px; border-top: 1px solid #e2e8f0;">
            <form action="{{ route('customer.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 500; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; gap: 12px; padding: 0;">
                    <span class="material-symbols-rounded">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content" id="main-content">
        @yield('content')
    </main>

    <!-- Add GSAP for smooth animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <!-- Alpine.js for Mobile Menu -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')
</body>

</html>