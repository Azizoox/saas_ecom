@extends('shop.layouts.app')

@section('title', 'Recherche - ' . $shop->name)

@section('content')
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