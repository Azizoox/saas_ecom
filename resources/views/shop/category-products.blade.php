@extends('shop.layouts.app')

@section('title', ($currentCategory ? $currentCategory->name . ' - ' : '') . $shop->name)

@section('content')
<div class="container py-4">
    <!-- Category Header -->
    @if($currentCategory)
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain]) }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $currentCategory->name }}
                        </li>
                    </ol>
                </nav>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            @if($currentCategory->image)
                                <div class="col-md-2 text-center">
                                    <img src="{{ Storage::url($currentCategory->image) }}" 
                                         alt="{{ $currentCategory->name }}" 
                                         class="img-fluid rounded" 
                                         style="max-height: 120px; object-fit: cover;">
                                </div>
                                <div class="col-md-10">
                            @else
                                <div class="col-12">
                            @endif
                                <h1 class="mb-2">{{ $currentCategory->name }}</h1>
                                @if($currentCategory->description)
                                    <p class="text-muted mb-0">{{ $currentCategory->description }}</p>
                                @endif
                                <div class="mt-2">
                                    <span class="badge bg-primary">{{ $products->count() }} produit{{ $products->count() > 1 ? 's' : '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row mb-4">
            <div class="col-12">
                <h1>Tous les produits</h1>
                <p class="text-muted">Découvrez tous nos produits</p>
            </div>
        </div>
    @endif

    <!-- Category Navigation -->
   

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 product-card border-0 shadow-sm hover-lift">
                        <!-- Product Image -->
                        <div class="position-relative">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            
                            @if($product->isInStock())
                                <span class="position-absolute top-0 start-0 m-2 badge bg-success">En stock</span>
                            @else
                                <span class="position-absolute top-0 start-0 m-2 badge bg-danger">Rupture</span>
                            @endif
                            
                            @if($product->category)
                                <span class="position-absolute top-0 end-0 m-2 badge bg-primary">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                        </div>
                        
                        <!-- Product Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2">
                                <a href="{{ route('shop.product', ['subdomain' => $shop->subdomain, 'id' => $product->id]) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ Str::limit($product->name, 50) }}
                                </a>
                            </h5>
                            
                            @if($product->short_description)
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($product->short_description, 80) }}
                                </p>
                            @elseif($product->description)
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit(strip_tags($product->description), 80) }}
                                </p>
                            @endif
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="h5 text-primary mb-0">{{ $product->formatted_price }}</span>
                                    </div>
                                    <div>
                                        @if($product->isInStock())
                                            <button class="btn btn-sm btn-primary add-to-cart" 
                                                    data-product-id="{{ $product->id }}">
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                                <i class="bi bi-cart-x"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="row mt-4">
                <div class="col-12">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    @else
        <div class="row">
            <div class="col-12 text-center py-5">
                <i class="bi bi-box-seam" style="font-size: 4rem; color: #ccc;"></i>
                <h3 class="mt-3">Aucun produit disponible</h3>
                <p class="text-muted">
                    @if($currentCategory)
                        Il n'y a aucun produit dans la catégorie "{{ $currentCategory->name }}" pour le moment.
                    @else
                        Aucun produit n'est disponible dans cette boutique.
                    @endif
                </p>
                <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain]) }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-1"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    @endif
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const quantity = 1;
            const buttonElement = this;
            
            // Show loading state
            const originalHtml = buttonElement.innerHTML;
            buttonElement.innerHTML = '<i class="bi bi-arrow-clockwise fa-spin"></i>';
            buttonElement.disabled = true;
            
            // Make AJAX request to add to cart
            fetch('{{ route("shop.cart.add", ["subdomain" => $shop->subdomain]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity)
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Show success feedback
                    buttonElement.innerHTML = '<i class="bi bi-check"></i>';
                    buttonElement.classList.remove('btn-primary');
                    buttonElement.classList.add('btn-success');
                    
                    // Update cart count in navigation if exists
                    document.querySelectorAll('.cart-count').forEach(element => {
                        element.textContent = data.cart_count;
                    });
                    
                    // Reset button after delay
                    setTimeout(() => {
                        buttonElement.innerHTML = originalHtml;
                        buttonElement.disabled = false;
                        buttonElement.classList.remove('btn-success');
                        buttonElement.classList.add('btn-primary');
                    }, 2000);
                } else {
                    alert(data.message || 'Erreur lors de l\'ajout au panier');
                    buttonElement.innerHTML = originalHtml;
                    buttonElement.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur s\'est produite lors de l\'ajout au panier');
                buttonElement.innerHTML = originalHtml;
                buttonElement.disabled = false;
            });
        });
    });
});
</script>
@endsection