<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ma Boutique')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- Fonts --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- <link rel="icon" href="{{ asset('images/img.jpg') }}" type="image/x-icon"> --}}
    @php
        $favicons = $shop->favicon ? \Illuminate\Support\Facades\Storage::url($shop->favicon) : asset('images/img.jpg');
    @endphp

        <link rel="icon" href="{{ $favicons }}" type="image/x-icon">
    
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">

    @php
        $accent = $shop->settings?->primary_color ?: '#f15a24';
        $accent = preg_match('/^#[0-9A-Fa-f]{6}$/', $accent) ? $accent : '#f15a24';

        $hexToRgb = function (string $hex): array {
            $hex = ltrim($hex, '#');
            return [
                hexdec(substr($hex, 0, 2)),
                hexdec(substr($hex, 2, 2)),
                hexdec(substr($hex, 4, 2)),
            ];
        };

        $mix = function (array $a, array $b, float $t): array {
            return [
                (int) round($a[0] + ($b[0] - $a[0]) * $t),
                (int) round($a[1] + ($b[1] - $a[1]) * $t),
                (int) round($a[2] + ($b[2] - $a[2]) * $t),
            ];
        };

        $rgb = $hexToRgb($accent);
        $darkRgb = $mix($rgb, [0, 0, 0], 0.18);     // ~18% darker
        $lightRgb = $mix($rgb, [255, 255, 255], 0.88); // very light tint

        $rgbToHex = function (array $c): string {
            return sprintf('#%02x%02x%02x', $c[0], $c[1], $c[2]);
        };

        $accentDark = $rgbToHex($darkRgb);
        $accentLight = $rgbToHex($lightRgb);
    @endphp

    <style>
        :root{
            --c-accent: {{ $accent }};
            --c-accent-dk: {{ $accentDark }};
            --c-accent-lt: {{ $accentLight }};
            --accent-color: var(--c-accent);
        }
    </style>

    {{-- Theme Script (runs early to prevent flash) --}}
    <script>
        (function() {
            const displayMode = '{{ $displayMode ?? "light" }}';
            const themeSelector = localStorage.getItem('shop-theme-selector');
            
            let themeToApply = displayMode;
            
            // If display_mode is 'auto', check system preference
            if (displayMode === 'auto') {
                if (themeSelector && (themeSelector === 'light' || themeSelector === 'dark')) {
                    themeToApply = themeSelector;
                } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    themeToApply = 'dark';
                } else {
                    themeToApply = 'light';
                }
            } else if (themeSelector) {
                // User overrode the setting
                themeToApply = themeSelector;
            }
            
            // Apply to <html> early (body may not exist yet)
            document.documentElement.classList.toggle('dark-mode', themeToApply === 'dark');
        })();
    </script>

<style>
    /* Prevent flash on dark mode */
    html.dark-mode body {
        background-color: var(--dark-bg, #1a1a1a);
        color: var(--dark-text, #e0e0e0);
    }
    /* Dark Mode Support */
    :root {
        --light-bg: #ffffff;
        --light-text: #000000;
        --light-border: #e0e0e0;
        --light-secondary-bg: #f5f5f5;
        --dark-bg: #1a1a1a;
        --dark-text: #e0e0e0;
        --dark-border: #333333;
        --dark-secondary-bg: #2a2a2a;
    }

    body {
        background-color: var(--light-bg);
        color: var(--light-text);
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    body.dark-mode,
    html.dark-mode body {
        background-color: var(--dark-bg);
        color: var(--dark-text);
    }

    /* Navigation in dark mode */
    body.dark-mode #mainNav {
        background: #1a1a1a !important;
        border-bottom: 1px solid var(--dark-border);
    }

    body.dark-mode .navbar-brand,
    body.dark-mode .nav-link {
        color: var(--dark-text) !important;
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select,
    body.dark-mode textarea {
        background-color: var(--dark-secondary-bg) !important;
        color: var(--dark-text) !important;
        border-color: var(--dark-border) !important;
    }

    body.dark-mode .form-control::placeholder {
        color: rgba(224, 224, 224, 0.6) !important;
    }

    body.dark-mode .card {
        background-color: var(--dark-secondary-bg);
        color: var(--dark-text);
        border-color: var(--dark-border);
    }

    body.dark-mode .btn-outline-light {
        color: var(--dark-text);
        border-color: var(--dark-text);
    }

    body.dark-mode .btn-outline-light:hover {
        background-color: var(--dark-secondary-bg);
        border-color: var(--dark-text);
    }

    body.dark-mode .dropdown-menu {
        background-color: var(--dark-secondary-bg);
        border-color: var(--dark-border);
    }

    body.dark-mode .dropdown-item {
        color: var(--dark-text);
    }

    body.dark-mode .dropdown-item:hover,
    body.dark-mode .dropdown-item:focus {
        background-color: var(--dark-border);
        color: var(--dark-text);
    }

    body.dark-mode .site-footer {
        background-color: var(--dark-secondary-bg) !important;
        color: var(--dark-text);
        border-top: 1px solid var(--dark-border);
    }

    body.dark-mode .alert {
        background-color: var(--dark-secondary-bg);
        color: var(--dark-text);
        border-color: var(--dark-border);
    }

    body.dark-mode .modal-content {
        background-color: var(--dark-secondary-bg);
        color: var(--dark-text);
        border-color: var(--dark-border);
    }

    body.dark-mode .close,
    body.dark-mode .btn-close {
        filter: invert(1);
    }

    body.dark-mode table {
        color: var(--dark-text);
    }

    body.dark-mode thead {
        background-color: var(--dark-border);
        color: var(--dark-text);
    }

    body.dark-mode tbody tr:hover {
        background-color: var(--dark-border);
    }

    /* Navbar Styling for Dark Mode */
    body.dark-mode #mainNav {
        background-color: #1a1a1a !important;
        border-bottom-color: #333333 !important;
    }

    body.dark-mode #mainNav a {
        color: #e0e0e0;
    }

    body.dark-mode #mainNav a:hover {
        color: var(--c-accent) !important;
    }

    body.dark-mode #mainNav button {
        color: #e0e0e0;
    }

    body.dark-mode #mainNav button:hover {
        color: var(--c-accent) !important;
    }

    /* Mobile Menu Dark Mode */
    body.dark-mode #mobileMenu {
        background-color: #2a2a2a !important;
    }

    body.dark-mode #mobileMenu a {
        color: #e0e0e0;
    }

    body.dark-mode #mobileMenu a:hover {
        background-color: rgba(241, 90, 36, 0.2) !important;
        color: var(--c-accent) !important;
    }

    body.dark-mode #mobileMenu button {
        color: #e0e0e0;
    }

    body.dark-mode #mobileMenu button:hover {
        background-color: rgba(241, 90, 36, 0.2) !important;
        color: var(--c-accent) !important;
    }

    /* Theme Toggle Button */
    .theme-toggle-btn {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0.5rem;
        margin-left: 0.5rem;
        transition: transform 0.3s ease;
    }

    .theme-toggle-btn:hover {
        transform: scale(1.2);
    }

    /* Back to Top Button Styles */
    .back-to-top-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: #f15a24;
        color: white;
        border: none;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        
    }
    
    .back-to-top-btn.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .back-to-top-btn:hover {
        background:rgb(181, 51, 4);
        box-shadow: 0 6px 20px rgba(181, 51, 4);
        transform: translateY(-3px);
       
    }
    
    .back-to-top-btn:active {
        transform: scale(0.95);
    }
    
    @media (max-width: 768px) {
        .back-to-top-btn {
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
            font-size: 1rem;
        }
    }
    .couleur:hover{
        color:var(--accent-color);
        transition: 0.3s all;
        
    }
       
</style>

@stack('styles')

<!-- Alpine.js for chatbot -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body>

@include('shop.components.navbar')

{{-- ── Hero / Banner components ────────────────────────── --}}
@php $components = $shop->components()->where('type', 'banner')->get(); @endphp
@if($components->isNotEmpty())
<div class="banner-section ">
    
        @foreach($components as $component)
        @include('shop.components.' . $component->type, [
            'id'         => $component->id,
            'content'    => $component->content,
            'shop'       => $shop,
            'categories' => $shop->categories()->where('is_active', true)->whereNull('parent_id')->get()
        ])
    @endforeach
   
    
</div>
@endif

{{-- ── Navbar ───────────────────────────────────────────── --}}
<nav class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm" id="mainNav">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            
            {{-- Brand --}}
            <a class="flex items-center gap-3 flex-shrink-0" href="{{ route('shop.index', ['subdomain' => $shop->subdomain ?? '']) }}">
                @if($shop && $shop->logo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($shop->logo) }}"
                         alt="{{ $shop->name }}" class="h-12 w-12 object-contain"> 
                @endif
                <span class="text-xl font-bold text-gray-900">{{ $shop->name ?? 'Ma Boutique' }}</span>
            </a>

            {{-- Nav Items - Desktop --}}
            <ul class="hidden lg:flex items-center gap-1 ml-auto">

                {{-- Search Form --}}
                <li class="flex items-center px-3">
                    <div class="relative">
                        @php
                            $shopSubdomain = $shop->subdomain ?? request()->route('subdomain', '');
                            $searchAction = \Illuminate\Support\Facades\Route::has('shop.search')
                                ? route('shop.search', ['subdomain' => $shopSubdomain])
                                : '#';
                        @endphp
                        <form class="flex items-center gap-2" id="searchForm" action="{{ $searchAction }}" method="GET">
                            <input class="px-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:border-orange-500" 
                                   type="search" name="q" id="searchInput" placeholder="Rechercher..." 
                                   value="{{ request('q', '') }}">
                            <button class="text-gray-600 hover:text-orange-500 transition" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                        
                        <!-- Live search results dropdown -->
                        <div id="searchResultsDropdown"
                             class="absolute top-full left-0 w-80 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg z-50"
                             style="display:none;max-height:340px;overflow-y:auto;">
                            <div class="px-4 py-3 bg-gray-100 border-b border-gray-200 text-xs font-bold text-gray-600 uppercase">Résultats</div>
                            <div id="searchResultsList"></div>
                        </div>
                    </div>
                </li>

                {{-- Categories Dropdown --}}
                @php
                    $categories = $shop->categories()->where('is_active', true)->whereNull('parent_id')->get();
                @endphp
                
                @if($categories->count() > 5)
                <li class="relative group">
                    <a class="flex items-center gap-2 px-4 py-2 text-gray-800 font-semibold text-sm couleur"
                       href="#">
                        <i class="bi bi-grid"></i>Catégories
                    </a>
                    <ul class="absolute left-0 top-full hidden group-hover:block bg-white border border-gray-200 rounded-lg shadow-lg w-48 py-2 z-40">
                        @foreach($categories as $category)
                        <li>
                            <a class="block px-4 py-2 text-gray-700 text-sm hover:bg-orange-50 couleur"
                               href="{{ route('shop.index', ['subdomain' => $shop->subdomain, 'category' => $category->slug]) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @endif

                {{-- Cart --}}
                <li>
                    <a class="flex items-center gap-2 px-4 py-2 text-gray-800 font-semibold text-sm couleur {{ request()->routeIs('shop.cart') ? 'text-orange-500' : '' }}"
                       href="{{ route('shop.cart', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}">
                        <i class="bi bi-bag"></i>Panier
                        <span class="ml-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full" id="cart-count">
                            <span id="cart-count-value">{{ \App\Models\Cart::getCartCount(auth()->id()) }}</span>
                        </span>
                    </a>
                </li>

                @auth
                
                {{-- @php 
                    $ordersCount = \App\Models\Order::where('user_id','!=', auth()->id())->count();
                @endphp --}}
                {{-- @if($ordersCount > 0 )  --}}
                <li >
                    <a class="flex items-center gap-2 px-4 py-2 text-gray-800 font-semibold text-sm couleur {{ request()->routeIs('shop.orders') ? 'text-orange-500' : '' }}"
                       href="{{ route('shop.orders', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}">
                        <i class="bi bi-list-check"></i>Mes commandes
                    </a>
                </li>
                  <li >
                    <a class="flex items-center gap-2 px-4 py-2 text-gray-800 font-semibold text-sm couleur }}"
                    href="/shop/{{ $shop->subdomain ?? request()->route('subdomain', '') }}/profile">
                        <i class="bi bi-list-check"></i>Mon Profile
                    </a>
                </li>
                {{-- @endif --}}
                <li>
                    <form action="{{ route('shop.logout', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="subdomain" value="{{ $shop->subdomain ?? request()->route('subdomain', '') }}">
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 text-gray-800 font-semibold text-sm couleur w-full text-left">
                            <i class="bi bi-box-arrow-right"></i>Déconnexion
                        </button>
                    </form>
                </li>
                @else
                <li>
                    <a class="flex items-center gap-2 px-4 py-2 text-gray-800 font-semibold text-sm couleur {{ request()->routeIs('shop.login') ? 'text-orange-500' : '' }}"
                       href="{{ route('shop.login', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}">
                        <i class="bi bi-person"></i>Login
                    </a>
                </li>
                <li>
                    <a class="flex items-center gap-2 px-4 py-2 text-gray-800 font-semibold text-sm couleur {{ request()->routeIs('shop.register') ? 'text-orange-500' : '' }}"
                       href="{{ route('shop.register', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}">
                        <i class="bi bi-person-plus"></i>Register
                    </a>
                </li>
                @endauth

                {{-- Theme Toggle --}}
                <li>
                    <button class="p-2 ml-2 text-gray-800 couleur" 
                            id="themeToggleBtn" title="Changer le thème" aria-label="Changer le thème">
                        <i class="bi bi-sun text-xl" id="themeIcon"></i>
                    </button>
                </li>
            </ul>

            {{-- Mobile Menu Button --}}
            <button class="lg:hidden text-gray-800 focus:outline-none" id="mobileMenuBtn">
                <i class="bi bi-list text-2xl"></i>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobileMenu" class="hidden lg:hidden absolute top-20 left-0 right-0 bg-white border-b border-gray-200 shadow-lg">
            <ul class="flex flex-col divide-y divide-gray-200">
                {{-- Mobile Search --}}
                <li class="px-4 py-3">
                    <div class="position-relative">
                        @php
                            $shopSubdomain = $shop->subdomain ?? request()->route('subdomain', '');
                            $searchAction = \Illuminate\Support\Facades\Route::has('shop.search')
                                ? route('shop.search', ['subdomain' => $shopSubdomain])
                                : '#';
                        @endphp
                        <form class="flex items-center gap-2" id="searchFormMobile" action="{{ $searchAction }}" method="GET">
                            <input class="flex-1 px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-orange-500" 
                                   type="search" name="q" id="searchInputMobile" placeholder="Rechercher..." 
                                   value="{{ request('q', '') }}">
                            <button class="text-gray-600 couleur" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </li>

                {{-- Mobile Categories --}}
                @php
                    $categories = $shop->categories()->where('is_active', true)->whereNull('parent_id')->get();
                @endphp
                
                @if($categories->count() > 0)
                <li>
                    <a class="flex items-center gap-2 px-4 py-3 text-gray-800 font-semibold text-sm hover:bg-orange-50 couleur"
                       href="#">
                        <i class="bi bi-grid"></i>Catégories
                    </a>
                </li>
                @endif

                {{-- Mobile Cart --}}
                <li>
                    <a class="flex items-center gap-2 px-4 py-3 text-gray-800 font-semibold text-sm hover:bg-orange-50 couleur"
                       href="{{ route('shop.cart', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}">
                        <i class="bi bi-bag"></i>Panier
                        <span class="ml-auto inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full" id="cart-count-mobile">
                            <span id="cart-count-value-mobile">{{ \App\Models\Cart::getCartCount(auth()->id()) }}</span>
                        </span>
                    </a>
                </li>

                @auth
                {{-- Mobile Orders --}}
                <li>
                    <a class="flex items-center gap-2 px-4 py-3 text-gray-800 font-semibold text-sm hover:bg-orange-50 couleur"
                       href="{{ route('shop.orders', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}">
                        <i class="bi bi-list-check"></i>Mes commandes
                    </a>
                </li>

                {{-- Mobile Logout --}}
                <li>
                    <form action="{{ route('shop.logout', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="subdomain" value="{{ $shop->subdomain ?? request()->route('subdomain', '') }}">
                        <button type="submit" class="flex items-center gap-2 px-4 py-3 text-gray-800 font-semibold text-sm hover:bg-orange-50 couleur w-full text-left">
                            <i class="bi bi-box-arrow-right"></i>Déconnexion
                        </button>
                    </form>
                </li>
                @else
                {{-- Mobile Login --}}
                <li>
                    <a class="flex items-center gap-2 px-4 py-3 text-gray-800 font-semibold text-sm hover:bg-orange-50 couleur"
                       href="{{ route('shop.login', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}">
                        <i class="bi bi-person"></i>Login
                    </a>
                </li>

                {{-- Mobile Register --}}
                <li>
                    <a class="flex items-center gap-2 px-4 py-3 text-gray-800 font-semibold text-sm hover:bg-orange-50 couleur"
                       href="{{ route('shop.register', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}">
                        <i class="bi bi-person-plus"></i>Register
                    </a>
                </li>
                @endauth

                {{-- Mobile Theme Toggle --}}
                <li class="px-4 py-3">
                    <button class="flex items-center gap-2 text-gray-800 couleur" 
                            id="themeToggleBtnMobile" title="Changer le thème" aria-label="Changer le thème">
                        <i class="bi bi-sun" id="themeIconMobile"></i>
                        <span class="text-sm font-semibold">Thème</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    
    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Close mobile menu when clicking on a link
    const mobileLinks = mobileMenu.querySelectorAll('a, button[type="submit"]');
    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });
    });

    const cartCountValue = document.getElementById('cart-count-value');
    const cartCountBadge = document.getElementById('cart-count');
    
    // Animate cart count change
    function animateCartCount(newCount) {
        if (!cartCountValue) return;
        
        // Scale up animation
        cartCountValue.style.transform = 'scale(1.3)';
        cartCountValue.style.opacity = '0.7';
        
        // Update count after animation
        setTimeout(() => {
            cartCountValue.textContent = newCount;
            cartCountValue.style.transform = 'scale(1)';
            cartCountValue.style.opacity = '1';
        }, 150);
    }
    
    // Update cart count from API
    function updateCartCountFromAPI() {
        fetch('/api/cart/count', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            const currentCount = parseInt(cartCountValue?.textContent || 0);
            const newCount = parseInt(data.count || 0);
            
            // Only animate if count changed
            if (currentCount !== newCount) {
                animateCartCount(newCount);
            }
        })
        .catch(error => console.error('Cart count update error:', error));
    }
    
    // Listen for product added events
    document.addEventListener('productAddedToCart', function(e) {
        // If event contains count, use it directly
        if (e.detail && e.detail.count !== undefined) {
            animateCartCount(e.detail.count);
        } else {
            // Otherwise fetch from API
            updateCartCountFromAPI();
        }
    });
    
    // Fallback: Update every 30 seconds
    setInterval(updateCartCountFromAPI, 30000);
    
    // Add CSS animations for cart count
    const style = document.createElement('style');
    style.textContent = `
        #cart-count-value {
            display: inline-block;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
        }
    `;
    document.head.appendChild(style);
});
</script>

            </ul>
        </div>
    </div>
</nav>

{{-- ── Page content ─────────────────────────────────────── --}}
<main>@yield('content')</main>

<!-- Back to Top Button -->
<button id="backToTop" class="back-to-top-btn" title="Retour en haut">
    <i class="bi bi-arrow-up"></i>
</button>

<footer class="site-footer" id="contact">
    <div class="container">
        <div class="row g-5">

            {{-- Brand --}}
            <div class="col-lg-4 col-md-6">
                <span class="footer-brand">{{ $shop->name }}</span>
                @if($shop->description)
                    <p class="footer-desc">{{ Str::limit($shop->description, 150) }}</p>
                @endif
                @if($shop->company_name)
                    <p class="mt-3 mb-1" style="font-size:.84rem;  font-weight:600;">{{ $shop->company_name }}</p>
                @endif
               
            </div>

            {{-- Contact --}}
            <div class="col-lg-4 col-md-6">
                <p class="footer-heading">Contact</p>

                @if($shop->contact_email)
                    <a href="mailto:{{ $shop->contact_email }}" class="footer-contact-item">
                        <i class="bi bi-envelope"></i>
                        {{ $shop->contact_email }}
                    </a>
                @endif
                @if($shop->contact_phone)
                    <a href="tel:{{ $shop->contact_phone }}" class="footer-contact-item">
                        <i class="bi bi-telephone"></i>
                        {{ $shop->contact_phone }}
                    </a>
                @endif
                @if($shop->street || $shop->city)
                    <span class="footer-contact-item">
                        <i class="bi bi-geo-alt"></i>
                        <span>
                            @if($shop->street){{ $shop->street }}@endif
                            @if($shop->city), {{ $shop->city }}@endif
                            @if($shop->state), {{ $shop->state }}@endif
                            @if($shop->postal_code) {{ $shop->postal_code }}@endif
                        </span>
                    </span>
                @endif
            </div>

            {{-- Social --}}
            <div class="col-lg-4 col-md-12">
                <p class="footer-heading">Suivez-nous</p>
                <div class="social-grid">
                    @if($shop->settings?->facebook_url)
                        <a href="{{ $shop->settings->facebook_url }}" target="_blank" class="social-btn" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                    @endif
                    @if($shop->settings?->instagram_url)
                        <a href="{{ $shop->settings->instagram_url }}" target="_blank" class="social-btn" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                    @endif
                    @if($shop->settings?->tiktok_url)
                        <a href="{{ $shop->settings->tiktok_url }}" target="_blank" class="social-btn" title="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                    @endif
                    @if($shop->settings?->twitter_url)
                        <a href="{{ $shop->settings->twitter_url }}" target="_blank" class="social-btn" title="Twitter / X">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                    @endif
                    @if($shop->settings?->youtube_url)
                        <a href="{{ $shop->settings->youtube_url }}" target="_blank" class="social-btn" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                    @endif
                    @if($shop->settings?->whatsapp_number)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $shop->settings->whatsapp_number) }}"
                           target="_blank" class="social-btn" title="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    @endif
                </div>
            </div>

        </div>

        {{-- Bottom bar --}}
        <div class="footer-bottom text-center">
            <p class="mb-1">&copy; {{ date('Y') }} {{ $shop->name }}. Tous droits réservés.</p>
            <p class="mb-0">Propulsé par <strong>Shoopino</strong></p>
        </div>
    </div>
</footer>

{{-- ── Scripts ──────────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Back to Top Button ── */
    const backToTopBtn = document.getElementById('backToTop');
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    }, { passive: true });
    
    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    /* ── Navbar shadow on scroll ── */
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 40);
    }, { passive: true });

    /* ── Live search ── */
    const searchInput           = document.getElementById('searchInput');
    const searchResultsDropdown = document.getElementById('searchResultsDropdown');
    const searchResultsList     = document.getElementById('searchResultsList');
    let searchTimeout, currentRequest;

    const hideResults = () => searchResultsDropdown.style.display = 'none';
    const showResults = () => searchResultsDropdown.style.display = 'block';

    function performSearch(query) {
        if (currentRequest) currentRequest.abort();
        if (query.length < 2) { hideResults(); return; }

        currentRequest = new XMLHttpRequest();
        const sub     = '{{ $shop->subdomain ?? request()->route("subdomain", "") }}';
        const baseUrl = '{{ \Illuminate\Support\Facades\Route::has("shop.search") ? route("shop.search", ["subdomain" => "___SUB___"]) : "#" }}';
        currentRequest.open('GET', baseUrl.replace('___SUB___', encodeURIComponent(sub)) + '?q=' + encodeURIComponent(query) + '&ajax=1', true);

        currentRequest.onload = function () {
            if (currentRequest.status !== 200) {
                searchResultsList.innerHTML = '<div class="dropdown-item disabled text-muted small">Erreur de recherche</div>';
                showResults(); return;
            }
            const resp = JSON.parse(currentRequest.responseText);
            if (resp.success && resp.products && resp.products.length > 0) {
                searchResultsList.innerHTML = '';
                resp.products.forEach(p => {
                    const a     = document.createElement('a');
                    a.href      = p.url;
                    a.className = 'search-result-item';
                    a.innerHTML = `
                        <div class="d-flex align-items-center">
                            ${p.image
                                ? `<img src="${p.image}" class="search-result-image" onerror="this.style.display='none'">`
                                : `<div class="search-result-image bg-light d-flex align-items-center justify-content-center rounded"><i class="bi bi-image text-muted"></i></div>`}
                            <div class="search-result-info">
                                <div class="search-result-title">${p.name}</div>
                                <div class="search-result-price">${p.price}</div>
                                ${p.description ? `<div class="search-result-description">${p.description.substring(0,60)}${p.description.length > 60 ? '…' : ''}</div>` : ''}
                            </div>
                        </div>`;
                    searchResultsList.appendChild(a);
                });
                showResults();
            } else {
                searchResultsList.innerHTML = '<div class="dropdown-item disabled text-muted small py-3 text-center">Aucun résultat</div>';
                showResults();
            }
        };
        currentRequest.onerror = () => {
            searchResultsList.innerHTML = '<div class="dropdown-item disabled text-muted small">Erreur réseau</div>';
            showResults();
        };
        currentRequest.send();
    }

    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        const q = this.value.trim();
        if (!q) { hideResults(); return; }
        searchTimeout = setTimeout(() => performSearch(q), 300);
    });

    searchInput.addEventListener('focus', function () {
        if (this.value.trim().length > 0) showResults();
    });

    searchInput.addEventListener('blur', () => setTimeout(hideResults, 200));
    searchResultsList.addEventListener('mousedown', e => e.preventDefault());
    document.addEventListener('click', e => {
        if (!searchResultsDropdown.contains(e.target) && e.target !== searchInput) hideResults();
    });

    /* ── Theme Toggle ── */
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const themeToggleBtnMobile = document.getElementById('themeToggleBtnMobile');
    const themeIcon = document.getElementById('themeIcon');
    const themeIconMobile = document.getElementById('themeIconMobile');
    const displayMode = '{{ $displayMode ?? "light" }}';
    const body = document.body;

    function updateThemeIcon(isDark) {
        themeIcon.className = isDark ? 'bi bi-moon text-xl' : 'bi bi-sun text-xl';
        themeIconMobile.className = isDark ? 'bi bi-moon' : 'bi bi-sun';
        themeIcon.title = isDark ? 'Passer au mode clair' : 'Passer au mode sombre';
        themeIconMobile.title = isDark ? 'Passer au mode clair' : 'Passer au mode sombre';
    }

    function applyTheme(theme) {
        const isDark = theme === 'dark';
        body.classList.toggle('dark-mode', isDark);
        document.documentElement.classList.toggle('dark-mode', isDark);
        updateThemeIcon(isDark);
    }

    function initTheme() {
        const themeSelector = localStorage.getItem('shop-theme-selector');
        let activeTheme = displayMode;

        if (displayMode === 'auto') {
            if (themeSelector && (themeSelector === 'light' || themeSelector === 'dark')) {
                activeTheme = themeSelector;
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                activeTheme = 'dark';
            } else {
                activeTheme = 'light';
            }
        } else if (themeSelector) {
            activeTheme = themeSelector;
        }

        applyTheme(activeTheme);

        // Listen for system theme changes (in auto mode)
        if (displayMode === 'auto' && window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('shop-theme-selector')) {
                    applyTheme(e.matches ? 'dark' : 'light');
                }
            });
        }
    }

    // Handle both desktop and mobile theme toggle
    const toggleTheme = function(e) {
        e.preventDefault();
        const isDarkNow = body.classList.contains('dark-mode');
        const newTheme = isDarkNow ? 'light' : 'dark';
        
        localStorage.setItem('shop-theme-selector', newTheme);
        applyTheme(newTheme);
    };

    themeToggleBtn.addEventListener('click', toggleTheme);
    themeToggleBtnMobile.addEventListener('click', toggleTheme);

    initTheme();
});
</script>

<!-- Chatbot Component -->
@include('components.shop.chatbot')

@stack('scripts')
</body>
</html>