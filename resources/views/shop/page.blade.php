    @extends('shop.layouts.app')

@section('title', $page->title . ' - ' . $shop->name)

@section('content')
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('shop.index', ['subdomain' => $shop->subdomain]) }}">{{ $shop->name }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @foreach($shop->pages()->where('is_active', true)->orderBy('order')->get() as $p)
                    <li class="nav-item">
                        <a class="nav-link {{ $p->id === $page->id ? 'active' : '' }}" href="{{ route('shop.page', ['subdomain' => $shop->subdomain, 'slug' => $p->slug]) }}">{{ $p->title }}</a>
                    </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.cart', ['subdomain' => $shop->subdomain]) }}">
                            <i class="bi bi-cart3 me-1"></i> Panier
                            <span class="badge bg-danger ms-1">{{ \App\Models\Cart::getCartCount(auth()->id()) }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>{{ $page->title }}</h1>
        <div class="mt-4">
            {!! $page->content !!}
        </div>

        @if(isset($products) && $products->count() > 0)
            <div class="mt-5">
                <h2 class="mb-4">Nos produits</h2>
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted flex-grow-1">
                                    @if($product->description)
                                        {{ strlen($product->description) > 100 ? substr($product->description, 0, 100) . '...' : $product->description }}
                                    @else
                                        <em>Aucune description</em>
                                    @endif
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="h5 text-primary mb-0">{{ $product->formatted_price }}</span>
                                    @if($product->isInStock())
                                        <span class="badge bg-success">En stock ({{ $product->stock }})</span>
                                    @else
                                        <span class="badge bg-danger">Rupture de stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @elseif(isset($products) && $products->count() === 0)
            <div class="mt-5">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Aucun produit disponible pour le moment.
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
