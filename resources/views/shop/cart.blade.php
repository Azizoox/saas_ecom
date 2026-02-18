@extends('shop.layouts.app')

@section('title', 'Panier - ' . ($shop->name ?? 'Ma Boutique'))

@section('content')
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
            background-color: #f9fafb;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .cart-item {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .cart-item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            border: 1px solid var(--border-color);
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .quantity-input {
            width: 50px;
            height: 35px;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: 5px;
        }

        .cart-summary {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .checkout-btn {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    

    <div class="container my-5">
        <h1 class="mb-4">Votre panier</h1>
        
        @if($cartItems && $cartItems->count() > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0">
                    <div class="card-body p-0">
                        @foreach($cartItems as $item)
                        <div class="cart-item">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                             class="cart-item-image w-100" 
                                             alt="{{ $item->product->name }}">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center cart-item-image w-100">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-5">
                                    <h5 class="mb-1">{{ $item->product->name }}</h5>
                                    <p class="text-muted mb-1">{!! $item->product->short_description ?? Str::limit($item->product->description, 100) !!}</p>
                                    <small class="text-muted">Prix unitaire: {{ number_format($item->product->price, 2, ',', ' ') }} TND</small>
                                </div>
                                <div class="col-md-2">
                                    <div class="quantity-controls">
                                        <button class="quantity-btn btn-decrease" data-product-id="{{ $item->product_id }}">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="number" 
                                               class="quantity-input" 
                                               value="{{ $item->quantity }}" 
                                               min="1" 
                                               max="{{ $item->product->stock }}"
                                               data-product-id="{{ $item->product_id }}">
                                        <button class="quantity-btn btn-increase" data-product-id="{{ $item->product_id }}">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <strong>{{ number_format($item->product->price * $item->quantity, 2, ',', ' ') }} TND</strong>
                                    <br>
                                    <button class="btn btn-sm btn-outline-danger btn-remove mt-2" 
                                            data-product-id="{{ $item->product_id }}">
                                        <i class="bi bi-trash"></i> Retirer
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="mt-4">
                    <button class="btn btn-outline-danger" id="clear-cart">
                        <i class="bi bi-x-circle me-2"></i>Vider le panier
                    </button>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h4 class="mb-4">Récapitulatif</h4>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sous-total:</span>
                        <strong>{{ number_format($totalPrice, 2, ',', ' ') }} TND</strong>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Livraison:</span>
                        <strong>Gratuite</strong>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total:</strong>
                        <strong class="fs-5">{{ number_format($totalPrice, 2, ',', ' ') }} TND</strong>
                    </div>
                    
                    <a href="{{ route('shop.checkout', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}" class="btn btn-primary checkout-btn w-100">
                        <i class="bi bi-credit-card me-2"></i>Commander
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 4rem; color: #cbd5e1;"></i>
            <h3 class="mt-3">Votre panier est vide</h3>
            <p class="text-muted">Commencez par ajouter des produits à votre panier</p>
            <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain ?? '']) }}" class="btn btn-primary">
                <i class="bi bi-shop me-2"></i>Explorer la boutique
            </a>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update quantity
        document.querySelectorAll('.btn-increase').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const input = this.previousElementSibling;
                let quantity = parseInt(input.value);
                
                if(quantity < parseInt(input.max)) {
                    input.value = quantity + 1;
                    updateQuantity(productId, input.value);
                }
            });
        });

        document.querySelectorAll('.btn-decrease').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const input = this.nextElementSibling;
                let quantity = parseInt(input.value);
                
                if(quantity > parseInt(input.min)) {
                    input.value = quantity - 1;
                    updateQuantity(productId, input.value);
                }
            });
        });

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const productId = this.dataset.productId;
                let quantity = parseInt(this.value);
                
                if(quantity < parseInt(this.min)) {
                    quantity = parseInt(this.min);
                    this.value = quantity;
                }
                
                if(quantity > parseInt(this.max)) {
                    quantity = parseInt(this.max);
                    this.value = quantity;
                }
                
                updateQuantity(productId, quantity);
            });
        });

        // Remove item
        document.querySelectorAll('.btn-remove').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                
                if(confirm('Êtes-vous sûr de vouloir retirer ce produit du panier?')) {
                    removeFromCart(productId);
                }
            });
        });

        // Clear cart
        document.getElementById('clear-cart').addEventListener('click', function() {
            if(confirm('Êtes-vous sûr de vouloir vider votre panier?')) {
                clearCart();
            }
        });

        function updateQuantity(productId, quantity) {
            fetch('{{ route("shop.cart.update", ["subdomain" => $shop->subdomain]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Update cart count in navigation
                    document.querySelectorAll('.badge.bg-danger.ms-1').forEach(badge => {
                        badge.textContent = data.cart_count;
                    });
                    
                    location.reload(); // Refresh the page to update all values
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function removeFromCart(productId) {
            fetch('{{ route("shop.cart.remove", ["subdomain" => $shop->subdomain]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Update cart count in navigation
                    document.querySelectorAll('.badge.bg-danger.ms-1').forEach(badge => {
                        badge.textContent = data.cart_count;
                    });
                    
                    location.reload(); // Refresh the page
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function clearCart() {
            fetch('{{ route("shop.cart.clear", ["subdomain" => $shop->subdomain]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Update cart count in navigation
                    document.querySelectorAll('.badge.bg-danger.ms-1').forEach(badge => {
                        badge.textContent = data.cart_count;
                    });
                    
                    location.reload(); // Refresh the page
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
@endsection