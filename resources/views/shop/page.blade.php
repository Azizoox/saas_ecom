    @extends('shop.layouts.app')

@section('title', $page->title . ' - ' . $shop->name)

@section('content')
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
@endsection
