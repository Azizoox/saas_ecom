<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - {{ config('app.name', 'Shoopino') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('images/img.jpg') }}" type="image/x-icon">
    
    <!-- Tailwind CSS for settings page -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    @stack('styles')
    
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }
        
        /* Enhanced Sidebar */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #0f172a 100%);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
            position: fixed;
            z-index: 1000;
            width: 260px;
        }
        
        .sidebar.collapsed {
            width: 70px;
        }
        
        .sidebar-brand {
            padding: 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }
        
        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sidebar-brand i {
            font-size: 1.75rem;
            color: var(--primary-color);
        }
        
        .sidebar-nav {
    padding: 1.5rem 0;
    overflow-y: auto;
    max-height: calc(100vh - 80px);
}

.sidebar-nav::-webkit-scrollbar {
    width: 4px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 4px;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}
        
        .nav-item {
            margin: 0.25rem 1rem;
        }
        
        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 0.65rem 0.95rem;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }
        
        .sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background: var(--primary-color);
            color: white;
            box-shadow: var(--card-shadow);
        }
        
        .sidebar .nav-link i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            transition: var(--transition);
            height: 100vh;
            width: 100%;
            
        }
        
        .sidebar.collapsed ~ .main-content {
            margin-left: 70px;
        }
        
        .topbar {
            background: white;
            box-shadow: var(--card-shadow);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .content-area {
            padding: 2rem;
        }
        
        /* Toggle Button */
        .sidebar-toggle {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .sidebar-toggle:hover {
            background: var(--primary-hover);
            transform: scale(1.05);
        }
        
        /* User Badge */
        .user-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }
        
        .user-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }
        
        /* User Profile Dropdown */
        .user-profile-dropdown {
            position: relative;
        }
        
        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            margin-top: 0.5rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1050;
        }
        
        .user-profile-dropdown:hover .user-dropdown-menu,
        .user-dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .user-dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #333;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .user-dropdown-menu .dropdown-item:hover {
            background-color: #f5f5f5;
            color: var(--primary-color);
            padding-left: 1.25rem;
        }
        
        .user-dropdown-menu .dropdown-divider {
            margin: 0.5rem 0;
            opacity: 0.3;
        }
           .agent-badge {
            background: #1e293b;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }
            
            .overlay.active {
                display: block;
            }
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-hover);
        }
    </style>
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="overlay" id="overlay"></div>
    
    <div class="d-flex">
        <!-- Enhanced Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <h4>
                    <!-- <i class="bi bi-shop"></i> -->
                    <img src="{{ asset('images/img.jpg') }}" alt="" width="55" height="55" class="rounded-circle">
                    
                    <span class="brand-text">Shoopino</span>
                </h4>
            </div>
            
            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    @if(auth()->user()->role === 'super_admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('super-admin.*') ? 'active' : '' }}" href="{{ route('super-admin.dashboard') }}">
                            <i class="bi bi-shield-lock"></i>
                            <span class="nav-text">Super Admin</span>
                        </a>
                    </li>
                    <li class="nav-item mt-4 pt-3 border-top border-gray-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-white w-100 text-start border-0 bg-transparent p-0">
                                <i class="bi bi-box-arrow-right"></i>
                                <span class="nav-text">Déconnexion</span>
                            </button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-box-seam"></i>
                            <span class="nav-text">Produits</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="bi bi-tags"></i>
                            <span class="nav-text">Catégories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('builder.*') ? 'active' : '' }}" href="{{ route('builder.index') }}">
                            <i class="bi bi-layout-text-sidebar-reverse"></i>
                            <span class="nav-text">Builder Page</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                            <i class="bi bi-cart-check"></i>
                            <span class="nav-text">Commandes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                            <i class="bi bi-receipt"></i>
                            <span class="nav-text">Factures</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('logistics.pickups') ? 'active' : '' }}" href="{{ route('logistics.pickups') }}">
                            <i class="bi bi-box-arrow-in-down"></i>
                            <span class="nav-text">Ramassage</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('logistics.packings') ? 'active' : '' }}" href="{{ route('logistics.packings') }}">
                            <i class="bi bi-box2"></i>
                            <span class="nav-text">Emballage</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('logistics.returns') ? 'active' : '' }}" href="{{ route('logistics.returns') }}">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            <span class="nav-text">Retours</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('stats.*') ? 'active' : '' }}" href="{{ route('stats.sales') }}">
                            <i class="bi bi-graph-up"></i>
                            <span class="nav-text">Statistiques</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                            <i class="bi bi-gear"></i>
                            <span class="nav-text">Paramètres</span>
                        </a>
                    </li>
                    
                    <!-- POS Menu Items -->
                    <li class="nav-item mt-3 pt-3 border-top border-gray-700">
                        <a class="nav-link {{ request()->routeIs('pos.*') ? 'active' : '' }}" href="{{ route('pos.index') }}">
                            <i class="bi bi-cash-coin"></i>
                            <span class="nav-text">Point de Vente</span>
                        </a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('pos.orders') ? 'active' : '' }}" href="{{ route('pos.orders') }}">
                            <i class="bi bi-list-check"></i>
                            <span class="nav-text">Commandes POS</span>
                        </a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link {{ request()->routeIs('pos.history') ? 'active' : '' }}" href="{{ route('pos.history') }}">
                            <i class="bi bi-journal-text"></i>
                            <span class="nav-text">Historique Caisse</span>
                        </a>
                    </li>
                    
                   
                    @endif
                </ul>
            </div>
        </nav>

        <!-- Main Content Area -->
        <div class="main-content" id="main-content">
            <!-- Enhanced Topbar -->
            <div class="topbar">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <button class="sidebar-toggle d-lg-none" id="mobile-toggle">
                            <i class="bi bi-list"></i>
                        </button>
                        <button class="sidebar-toggle d-none d-lg-block" id="desktop-toggle">
                            <i class="bi bi-layout-sidebar"></i>
                        </button>
                        <h1 class="h3 mb-0">@yield('title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="d-flex align-items-center gap-3">
                        <!-- <div class="position-relative">
                            <button class="btn btn-light rounded-circle position-relative" style="width: 40px; height: 40px;">
                                <i class="bi bi-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    3
                                </span>
                            </button>
                        </div> -->
                        <div class="user-profile-dropdown">
                            <div class="user-badge" id="userBadge">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ auth()->user()->email }}
                                <i class="bi bi-chevron-down ms-2" style="font-size: 0.8rem;"></i>
                            </div>
                            <div class="user-dropdown-menu" id="userDropdownMenu">
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <i class="bi bi-person me-2"></i>Mon Profil
                                </a>
                                <a href="{{ route('settings.index') }}" class="dropdown-item">
                                    <i class="bi bi-gear me-2"></i>Paramètres
                                </a>
                                <hr class="dropdown-divider">
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item w-100 text-start border-0 bg-transparent">
                                        <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="agent-badge d-none">
                                <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-white w-100 text-start">
                                <i class="bi bi-box-arrow-right"></i>
                                <span class="nav-text">Déconnexion</span>
                            </button>
                        </form>
                        </div>
                     
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area fade-in">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const desktopToggle = document.getElementById('desktop-toggle');
            const mobileToggle = document.getElementById('mobile-toggle');
            const overlay = document.getElementById('overlay');
            const userBadge = document.getElementById('userBadge');
            const userDropdownMenu = document.getElementById('userDropdownMenu');
            
            // Desktop sidebar toggle
            if (desktopToggle) {
                desktopToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    
                    // Toggle text visibility
                    const navTexts = document.querySelectorAll('.nav-text');
                    const brandText = document.querySelector('.brand-text');
                    
                    if (sidebar.classList.contains('collapsed')) {
                        navTexts.forEach(text => text.style.display = 'none');
                        if (brandText) brandText.style.display = 'none';
                    } else {
                        navTexts.forEach(text => text.style.display = 'inline');
                        if (brandText) brandText.style.display = 'inline';
                    }
                });
            }
            
            // Mobile sidebar toggle
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.add('active');
                    overlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }
            
            // Overlay click to close
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                });
            }
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickInsideToggle = mobileToggle && mobileToggle.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickInsideToggle && window.innerWidth < 992) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
            
            // User Profile Dropdown Toggle
            if (userBadge) {
                userBadge.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (userDropdownMenu) {
                        userDropdownMenu.classList.toggle('show');
                    }
                });
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInsideDropdown = userDropdownMenu && userDropdownMenu.contains(event.target);
                const isClickInsideBadge = userBadge && userBadge.contains(event.target);
                
                if (!isClickInsideDropdown && !isClickInsideBadge && userDropdownMenu) {
                    userDropdownMenu.classList.remove('show');
                }
            });
            
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>
