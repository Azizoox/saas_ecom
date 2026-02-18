@extends('shop.layouts.app')

@section('title', 'Recherche - ' . $shop->name)

@section('content')
<style>
    .search-results-container {
        padding: 2rem 0;
    }
    
    .search-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    
    .search-query {
        font-size: 1.5rem;
        font-weight: bold;
    }
    
    .search-count {
        opacity: 0.9;
    }
    
    .product-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        height: 100%;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    .product-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 200px;
        background: #f8f9fa;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-body {
        padding: 1.5rem;
    }
    
    .product-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-description {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }
    
    .no-results {
        text-align: center;
        padding: 3rem;
        color: var(--text-light);
    }
    
    .no-results i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    .search-suggestions {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 1rem;
        margin-bottom: 2rem;
    }
    
    .search-suggestions h5 {
        margin-bottom: 1rem;
        color: var(--primary-color);
    }
    
    .search-suggestions ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .search-suggestions li {
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .search-suggestions li:last-child {
        border-bottom: none;
    }
</style>

<div class="search-header">
    <div class="container">
        <h1 class="text-center mb-0">
            <i class="bi bi-search me-2"></i>
            <span class="search-query">Résultats pour "{{ $query }}"</span>
        </h1>
        <p class="text-center search-count mt-2">
            {{ $products->count() }} résultat(s) trouvé(s)
        </p>
    </div>
</div>

<div class="container search-results-container">
    @if($products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="product-image" 
                                 alt="{{ $product->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="product-body">
                        <h5 class="product-title">{{ $product->name }}</h5>
                        
                        @if($product->short_description)
                            <p class="product-description">{!! Str::limit($product->short_description, 100) !!}</p>
                        @elseif($product->description)
                            <p class="product-description">{!! Str::limit($product->description, 100) !!}</p>
                        @endif
                        
                        <div class="product-price">{{ $product->formatted_price }}</div>
                        
                        <div class="d-grid">
                            <a href="{{ route('shop.product', ['subdomain' => $shop->subdomain, 'id' => $product->id]) }}" 
                               class="btn btn-primary">
                                <i class="bi bi-eye me-1"></i>Voir le produit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="no-results">
            <i class="bi bi-search"></i>
            <h3>Aucun résultat trouvé</h3>
            <p class="text-muted">Nous n'avons trouvé aucun produit correspondant à votre recherche "{{ $query }}"</p>
            <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain]) }}" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i>Retour à l'accueil
            </a>
        </div>
    @endif
</div>

@endsection