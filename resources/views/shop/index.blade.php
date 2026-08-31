@extends('shop.layouts.app')

@section('title', $shop->name)

@section('content')


@php $components = $shop->components()->where('type', '!=', 'banner')->get(); @endphp
@foreach($components as $component)
    @include('shop.components.' . $component->type, [
        'id'         => $component->id,
        'content'    => $component->content,
        'shop'       => $shop,
        'categories' => $shop->categories()->where('is_active', true)->whereNull('parent_id')->get()
    ])
@endforeach


{{-- ============================================================
     PRODUCTS SECTION
============================================================ --}}
<section class="products-section" id="products">
    <div class="container">

        @if(isset($products) && $products->count() > 0)

            <div class="section-header">
              
                <h2 class="section-title">
                    @if(isset($currentCategory) && $currentCategory)
                        {{ $currentCategory->name }}
                    @else
                        Nos Produits
                    @endif
                </h2>
                <div class="section-divider"></div>
                <p class="section-subtitle text-center m-4">
                    @if(isset($currentCategory) && $currentCategory)
                        Tous les produits de cette catégorie
                    @else
                        Découvrez notre sélection soigneusement choisie
                    @endif
                </p>
            </div>
            @include('components.shop.chatbot')

            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-xl-3 col-lg-4 col-sm-6 fade-in-up"
                     style="animation-delay: {{ min($loop->index * 0.07, 0.5) }}s">
                    <div class="product-card">

                        {{-- Image --}}
                        <div class="product-image-wrapper">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="product-image"
                                     alt="{{ $product->name }}"
                                     loading="lazy">
                            @else
                                <div class="product-no-image">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif

                            <span class="product-badge {{ $product->isInStock() ? 'product-badge-stock' : 'product-badge-rupture' }}">
                                {{ $product->isInStock() ? 'En stock' : 'Rupture' }}
                            </span>

                            <div class="product-overlay">
                                <a href="{{ route('shop.product', ['subdomain' => $shop->subdomain, 'id' => $product->id]) }}"
                                   class="overlay-link">
                                    <i class="bi bi-eye me-1"></i> Voir le produit
                                </a>
                            </div>
                        </div>

                        {{-- Body --}}
                        <div class="product-body">
                            <h5 class="product-title">{{ $product->name }}</h5>

                            @if($product->short_description)
                                <p class="product-description">{!! $product->short_description !!}</p>
                            @elseif($product->description)
                                <p class="product-description">{!! $product->description !!}</p>
                            @else
                                <p class="product-description"><em>Aucune description</em></p>
                            @endif

                            <div class="product-price">{{ $product->formatted_price }}</div>
                        </div>

                        {{-- Footer --}}
                        <div class="product-footer">
                            @if($product->isInStock())
                                <span class="stock-label in-stock">
                                    <i class="bi bi-check-circle-fill"></i>
                                    {{ $product->stock }} dispo
                                </span>
                            @else
                                <span class="stock-label out-stock">
                                    <i class="bi bi-x-circle-fill"></i>
                                    Rupture
                                </span>
                            @endif

                            <div class="d-flex gap-2">
                                @if($product->isInStock())
                                    <button class="btn-cart btn-add-cart-list"
                                            data-product-id="{{ $product->id }}"
                                            title="Ajouter au panier">
                                        <i class="bi bi-bag-plus"></i>
                                    </button>
                                @endif
                                <a href="{{ route('shop.product', ['subdomain' => $shop->subdomain, 'id' => $product->id]) }}"
                                   class="btn-detail" title="Voir le produit">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

        @endif

    </div>
</section>


{{-- ============================================================
     FEATURES STRIP
============================================================ --}}
<section class="features-section">
    <div class="container">
        <div class="row g-4 justify-content-center">

            <div class="col-lg-3 col-6">
                <div class="feature-item">
                    <div class="feature-icon-wrap"><i class="bi bi-truck"></i></div>
                    <div class="feature-text-wrap">
                        <h4>Livraison rapide</h4>
                        <p>Livraison à domicile en 24–48 h</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="feature-item">
                    <div class="feature-icon-wrap"><i class="bi bi-shield-check"></i></div>
                    <div class="feature-text-wrap">
                        <h4>Paiement sécurisé</h4>
                        <p>Transactions 100 % protégées</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="feature-item">
                    <div class="feature-icon-wrap"><i class="bi bi-arrow-clockwise"></i></div>
                    <div class="feature-text-wrap">
                        <h4>Retour gratuit</h4>
                        <p>30 jours pour changer d'avis</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="feature-item">
                    <div class="feature-icon-wrap"><i class="bi bi-headset"></i></div>
                    <div class="feature-text-wrap">
                        <h4>Support 24/7</h4>
                        <p>Service client disponible</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ============================================================
     FOOTER
============================================================ --}}



<script>
    // Toast notification styles
    const style = document.createElement('style');
    style.textContent = `
        .cart-toast {
            position: fixed;
            top: 100px;
            right: -400px;
            background: white;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 320px;
            max-width: 400px;
            z-index: 9999;
            transition: right 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border-left: 4px solid #27a04a;
        }
        
        .cart-toast.show {
            right: 20px;
        }
        
        .cart-toast.error {
            border-left-color: #e53e3e;
        }
        
        .toast-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        
        .cart-toast .toast-icon {
            color: #27a04a;
        }
        
        .cart-toast.error .toast-icon {
            color: #e53e3e;
        }
        
        .toast-content {
            flex: 1;
        }
        
        .toast-message {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d2d2d;
            line-height: 1.4;
        }
        
        @media (max-width: 768px) {
            .cart-toast {
                top: 80px;
                right: -100%;
                left: 20px;
                right: 20px;
                min-width: auto;
                max-width: none;
            }
            
            .cart-toast.show {
                right: 20px;
                left: 20px;
            }
        }
    `;
    document.head.appendChild(style);

    /* ── Smooth scroll ── */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
        });
    });

    /* ── Intersection observer fade-up ── */
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.fade-in-up').forEach(el => {
        el.style.animationPlayState = 'paused';
        observer.observe(el);
    });

    /* ── Add to cart ── */
    document.querySelectorAll('.btn-add-cart-list').forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.dataset.productId;

            fetch('{{ route("shop.cart.add", ["subdomain" => $shop->subdomain]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const orig = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-check-lg"></i>';
                    this.classList.add('success');

                    // Update cart count with smooth animation
                    const cartCountValue = document.getElementById('cart-count-value');
                    if (cartCountValue) {
                        cartCountValue.style.transform = 'scale(1.3)';
                        cartCountValue.style.opacity = '0.7';
                        
                        setTimeout(() => {
                            cartCountValue.textContent = data.cart_count;
                            cartCountValue.style.transform = 'scale(1)';
                            cartCountValue.style.opacity = '1';
                        }, 150);
                    }

                    // Show success toast notification
                    showAddToCartToast(data.message || 'Produit ajouté au panier avec succès!');

                    setTimeout(() => {
                        this.innerHTML = orig;
                        this.classList.remove('success');
                    }, 1500);
                } else {
                    showErrorToast(data.message || 'Erreur lors de l\'ajout au panier');
                }
            })
            .catch(() => showErrorToast('Une erreur s\'est produite'));
        });
    });

    // Toast notification functions
    function showAddToCartToast(message) {
        const toast = document.createElement('div');
        toast.className = 'cart-toast';
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="toast-content">
                <div class="toast-message">${message}</div>
            </div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.add('show'), 10);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }

    function showErrorToast(message) {
        const toast = document.createElement('div');
        toast.className = 'cart-toast error';
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="toast-content">
                <div class="toast-message">${message}</div>
            </div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.add('show'), 10);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
</script>

@endsection