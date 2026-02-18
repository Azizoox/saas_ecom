<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ma Boutique')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #f59e0b;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .search-result-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            text-decoration: none;
            color: var(--text-dark);
            display: block;
        }
        
        .search-result-item:last-child {
            border-bottom: none;
        }
        
        .search-result-item:hover {
            background-color: #f8f9fa;
            text-decoration: none;
        }
        
        .search-result-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 10px;
        }
        
        .search-result-info {
            flex: 1;
        }
        
        .search-result-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .search-result-price {
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .search-result-description {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-top: 0.25rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('shop.index', ['subdomain' => $shop->subdomain ?? '']) }}">
                @if($shop && $shop->logo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($shop->logo) }}" alt="{{ $shop->name }}" style="height: 40px; margin-right: 10px;">
                @endif
                {{ $shop->name ?? 'Ma Boutique' }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- Search Form -->
                    <li class="nav-item me-3">
                        <div class="position-relative">
                            @php
                                $shopSubdomain = $shop->subdomain ?? request()->route('subdomain', '');
                                $searchAction = \Illuminate\Support\Facades\Route::has('shop.search')
                                    ? route('shop.search', ['subdomain' => $shopSubdomain])
                                    : '#';
                            @endphp
                            <form class="d-flex" id="searchForm" action="{{ $searchAction }}" method="GET">
                                <input class="form-control me-2" type="search" name="q" id="searchInput" placeholder="Rechercher un produit..." aria-label="Search" value="{{ request('q', '') }}">
                                <button class="btn btn-outline-light" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                            
                            <!-- Live search results dropdown -->
                            <div id="searchResultsDropdown" class="dropdown-menu w-100 position-absolute" style="z-index: 1000; max-height: 300px; overflow-y: auto; display: none;">
                                <div class="dropdown-header">Résultats de recherche</div>
                                <div id="searchResultsList"></div>
                            </div>
                        </div>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.index', ['subdomain' => $shop->subdomain ?? '']) }}">
                            <i class="bi bi-house-door me-1"></i> Accueil
                        </a>
                    </li>
                    <!-- @if($shop)
                        @foreach($shop->pages()->where('is_active', true)->orderBy('order')->get() as $page)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('shop.page') && $page->slug == (request()->route('slug') ?? '') ? 'active' : '' }}" 
                               href="{{ route('shop.page', ['subdomain' => $shop->subdomain, 'slug' => $page->slug]) }}">{{ $page->title }}</a>
                        </li>
                        @endforeach
                    @endif --> 
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.cart', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}">
                            <i class="bi bi-cart3 me-1"></i> Panier
                            <span class="badge bg-danger ms-1">{{ \App\Models\Cart::getCartCount(auth()->id()) }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Live search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');
            const searchResultsDropdown = document.getElementById('searchResultsDropdown');
            const searchResultsList = document.getElementById('searchResultsList');
            
            let searchTimeout;
            let currentRequest = null;
            
            function hideResults() {
                searchResultsDropdown.style.display = 'none';
            }
            
            function showResults() {
                searchResultsDropdown.style.display = 'block';
            }
            
            function performSearch(query) {
                if (currentRequest) {
                    currentRequest.abort();
                }
                
                if (query.length < 2) {
                    hideResults();
                    return;
                }
                
                currentRequest = new XMLHttpRequest();
                const shopSubdomain = '{{ $shop->subdomain ?? request()->route("subdomain", "") }}';
                const baseSearchUrl = '{{ \Illuminate\Support\Facades\Route::has("shop.search") ? route("shop.search", ["subdomain" => "___SUB___"]) : "#" }}';
                const finalSearchUrl = baseSearchUrl.replace("___SUB___", encodeURIComponent(shopSubdomain));
                currentRequest.open('GET', finalSearchUrl + '?q=' + encodeURIComponent(query) + '&ajax=1', true);
                
                currentRequest.onload = function() {
                    if (currentRequest.status === 200) {
                        const response = JSON.parse(currentRequest.responseText);
                        
                        if (response.success && response.products && response.products.length > 0) {
                            searchResultsList.innerHTML = '';
                            
                            response.products.forEach(function(product) {
                                const item = document.createElement('a');
                                item.href = product.url;
                                item.className = 'search-result-item';
                                item.innerHTML = `
                                    <div class="d-flex align-items-center">
                                        ${product.image ? `<img src="${product.image}" class="search-result-image" onerror="this.style.display='none'">` : `<div class="search-result-image bg-light d-flex align-items-center justify-content-center"><i class="bi bi-image text-muted"></i></div>`}
                                        <div class="search-result-info">
                                            <div class="search-result-title">${product.name}</div>
                                            <div class="search-result-price">${product.price}</div>
                                            ${product.description ? `<div class="search-result-description">${product.description.substring(0, 60)}${product.description.length > 60 ? '...' : ''}</div>` : ''}
                                        </div>
                                    </div>
                                `;
                                searchResultsList.appendChild(item);
                            });
                            
                            showResults();
                        } else {
                            searchResultsList.innerHTML = '<div class="dropdown-item disabled">Aucun résultat trouvé</div>';
                            showResults();
                        }
                    } else if (currentRequest.status !== 0) { // 0 means request was aborted
                        searchResultsList.innerHTML = '<div class="dropdown-item disabled">Erreur de recherche</div>';
                        showResults();
                    }
                };
                
                currentRequest.onerror = function() {
                    searchResultsList.innerHTML = '<div class="dropdown-item disabled">Erreur de réseau</div>';
                    showResults();
                };
                
                currentRequest.send();
            }
            
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                
                const query = this.value.trim();
                
                if (query.length === 0) {
                    hideResults();
                    return;
                }
                
                searchTimeout = setTimeout(function() {
                    performSearch(query);
                }, 300); // Delay 300ms after user stops typing
            });
            
            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length > 0) {
                    showResults();
                }
            });
            
            searchInput.addEventListener('blur', function() {
                // Small delay to allow clicking on results
                setTimeout(hideResults, 200);
            });
            
            // Prevent form submission when selecting from dropdown
            searchResultsList.addEventListener('mousedown', function(e) {
                e.preventDefault();
            });
            
            // Hide results when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchResultsDropdown.contains(e.target) && e.target !== searchInput) {
                    hideResults();
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>