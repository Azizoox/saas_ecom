@extends('layouts.dashboard')

@section('title', 'Point de Vente - POS')

@section('content')
<div class="container-fluid">
    <div class="row">           
        <!-- Left Panel - POS Interface -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-cart-check me-2"></i>Point de Vente
                    </h5>
                </div>
                <div class="card-body">
                    @if($currentSession)
                        <!-- Current Session Info -->
                        <div class="alert alert-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Caisse:</strong> {{ $currentRegister->name }}<br>
                                    <strong>Agent:</strong> {{ $currentSession->user->getFullNameAttribute() }}<br>
                                    <strong>Ouverte à:</strong> {{ $currentSession->opened_at->format('d/m/Y H:i') }}
                                </div>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#closeRegisterModal">
                                    <i class="bi bi-door-closed me-1"></i>Fermer Caisse
                                </button>
                            </div>
                        </div>

                        <!-- Product Search -->
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" id="product-search" class="form-control" placeholder="Rechercher un produit par nom ou SKU...">
                                <button class="btn btn-outline-secondary" type="button" id="scan-barcode">
                                    <i class="bi bi-upc-scan"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Products Grid -->
                        <div class="row g-3 mb-4" id="products-grid">
                            @php
                                $shop = auth()->user()->shop;
                            @endphp
                            
                            @foreach(\App\Models\Product::where('shop_id', $shop->id)->where('is_active', true)->limit(12)->get() as $product)
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="card product-card h-100" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}">
                                       <img src="{{ asset('storage/' . $product->image) }}"  alt="{{ $product->name }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <h6 class="card-title small mb-1">{{ Str::limit($product->name, 20) }}</h6>
                                            <p class="card-text small text-muted mb-1">{{ $product->sku }}</p>
                                            <p class="card-text fw-bold text-primary">{{ number_format($product->price, 3, '.', ' ') }} TND</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Cart Section -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-cart me-2"></i>Panier
                                    <span class="badge bg-primary float-end" id="cart-count">0</span>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0" id="cart-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Produit</th>
                                                <th>Qté</th>
                                                <th>Prix</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-items">
                                            <!-- Cart items will be added here -->
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="border rounded p-3">
                                            <div class="d-flex justify-content-between">
                                                <span>Sous-total:</span>
                                                <strong id="cart-subtotal">0.000 TND</strong>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>TVA:</span>
                                                <span id="cart-tax">0.000 TND</span>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between fs-5 fw-bold">
                                                <span>Total:</span>
                                                <span id="cart-total">0.000 TND</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="border rounded p-3">
                                            <div class="mb-2">
                                                <label class="form-label">Moyen de paiement</label>
                                                <select class="form-select" id="payment-method">
                                                    <option value="cash">Espèces</option>
                                                    <option value="card">Carte Bancaire</option>
                                                    <option value="mobile">Mobile Money</option>
                                                    <option value="transfer">Virement</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-success w-100" id="complete-order">
                                                <i class="bi bi-check-circle me-2"></i>Terminer la vente
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-cash-stack" style="font-size: 3rem; color: #6c757d;"></i>
                            <h3 class="mt-3">Aucune caisse ouverte</h3>
                            <p class="text-muted">Veuillez ouvrir une caisse pour commencer les ventes</p>
                            
                            @if($cashRegisters->count() > 0)
                                <div class="row justify-content-center mt-4">
                                    @foreach($cashRegisters as $register)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $register->name }}</h5>
                                                    @if($register->location)
                                                        <p class="card-text text-muted">{{ $register->location }}</p>
                                                    @endif>
                                                    <button type="button" class="btn btn-primary w-100" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#openRegisterModal"
                                                            data-register-id="{{ $register->id }}"
                                                            data-register-name="{{ $register->name }}">
                                                        <i class="bi bi-door-open me-2"></i>Ouvrir
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning mt-4">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Aucune caisse disponible. Veuillez créer une caisse d'abord.
                                </div>
                            @endif
                            
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#createRegisterModal">
                                <i class="bi bi-plus-circle me-2"></i>Créer une caisse
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Panel - Quick Actions -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>Actions Rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('pos.orders') }}" class="btn btn-outline-primary">
                            <i class="bi bi-list-check me-2"></i>Commandes POS
                        </a>
                        <a href="{{ route('pos.history') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-journal-text me-2"></i>Historique Caisse
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-info">
                            <i class="bi bi-box-seam me-2"></i>Gérer Produits
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="card shadow-sm mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-receipt me-2"></i>Ventes Récentes
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $recentOrders = \App\Models\PosOrder::whereHas('cashRegisterSession', function($query) {
                            $query->where('user_id', auth()->id());
                        })->orderBy('created_at', 'desc')->limit(5)->get();
                    @endphp
                    
                    @forelse($recentOrders as $order)
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <div>
                                <small>{{ $order->formatted_order_number }}</small><br>
                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                            </div>
                            <div class="text-end">
                                <strong>{{ number_format($order->total_amount, 3, '.', ' ') }} TND</strong><br>
                                <small class="text-muted">{{ $order->payment_method_label }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center mb-0">Aucune vente récente</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Open Register Modal -->
<div class="modal fade" id="openRegisterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pos.register.open') }}" method="POST">
                @csrf
                <input type="hidden" name="cash_register_id" id="modal-cash-register-id" value="">
                <div class="modal-header">
                    <h5 class="modal-title">Ouvrir Caisse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Caisse</label>
                        <input type="text" class="form-control" id="modal-register-name" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Solde initial</label>
                        <input type="number" step="0.001" name="opening_balance" class="form-control" value="0" required>
                        <div class="form-text">Solde initial dans la caisse</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ouvrir Caisse</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Close Register Modal -->
@if($currentSession)
<div class="modal fade" id="closeRegisterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pos.register.close') }}" method="POST">
                @csrf
                <input type="hidden" name="session_id" value="{{ $currentSession->id }}">
                <div class="modal-header">
                    <h5 class="modal-title">Fermer Caisse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Solde réel en caisse</label>
                        <input type="number" step="0.001" name="actual_closing_balance" class="form-control" required>
                        <div class="form-text">Montant réellement présent dans la caisse</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes (optionnel)</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Fermer Caisse</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Create Register Modal -->
<div class="modal fade" id="createRegisterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pos.register.create') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Créer une Caisse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom de la caisse</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Emplacement (optionnel)</label>
                        <input type="text" name="location" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer Caisse</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let cart = [];
    
    // Set up register modal
    const openRegisterModal = document.getElementById('openRegisterModal');
    openRegisterModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const registerId = button.getAttribute('data-register-id');
        const registerName = button.getAttribute('data-register-name');
        
        document.getElementById('modal-cash-register-id').value = registerId;
        document.getElementById('modal-register-name').value = registerName;
    });
    
    // Product card click
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const price = parseFloat(this.dataset.productPrice);
            
            addToCart(productId, productName, price);
        });
    });
    
    // Add to cart function
    function addToCart(productId, productName, price) {
        const existingItem = cart.find(item => item.id == productId);
        
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: price,
                quantity: 1
            });
        }
        
        updateCart();
    }
    
    // Update cart display
    function updateCart() {
        const cartItems = document.getElementById('cart-items');
        const cartCount = document.getElementById('cart-count');
        const cartSubtotal = document.getElementById('cart-subtotal');
        const cartTax = document.getElementById('cart-tax');
        const cartTotal = document.getElementById('cart-total');
        
        cartItems.innerHTML = '';
        
        let subtotal = 0;
        let tax = 0;
        let total = 0;
        
        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            const itemTax = 0; // Assuming 19% VAT itemTotal * 0.19
            
            subtotal += itemTotal;
            tax += itemTax;
            total += itemTotal + itemTax;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.name}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${index}, -1)">-</button>
                        <span class="mx-2">${item.quantity}</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${index}, 1)">+</button>
                    </div>
                </td>
                <td>${item.price.toFixed(3)} TND</td>
                <td>${itemTotal.toFixed(3)} TND</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="removeFromCart(${index})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            
            cartItems.appendChild(row);
        });
        
        cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartSubtotal.textContent = subtotal.toFixed(3) + ' TND';
        cartTax.textContent = tax.toFixed(3) + ' TND';
        cartTotal.textContent = total.toFixed(3) + ' TND';
    }
    
    // Update quantity function
    window.updateQuantity = function(index, change) {
        cart[index].quantity += change;
        
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        
        updateCart();
    };
    
    // Remove from cart function
    window.removeFromCart = function(index) {
        cart.splice(index, 1);
        updateCart();
    };
    
    // Complete order
    document.getElementById('complete-order').addEventListener('click', function() {
        if (cart.length === 0) {
            alert('Le panier est vide!');
            return;
        }
        
        const paymentMethod = document.getElementById('payment-method').value;
        
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('payment_method', paymentMethod);
        
        cart.forEach((item, index) => {
            formData.append(`items[${index}][product_id]`, item.id);
            formData.append(`items[${index}][quantity]`, item.quantity);
        });
        
        fetch('{{ route("pos.order.create") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                alertDiv.innerHTML = `
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Commande créée avec succès!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="this.parentElement.remove();"></button>
                `;
                document.body.appendChild(alertDiv);
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
                
                cart = [];
                updateCart();
            } else {
                // Show error message
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                alertDiv.style.top = '20px';
                alertDiv.style.right = '20px';
                alertDiv.style.zIndex = '9999';
                alertDiv.innerHTML = `
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Erreur: ${data.error || 'Une erreur est survenue'}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="this.parentElement.remove();"></button>
                `;
                document.body.appendChild(alertDiv);
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error message
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '9999';
            alertDiv.innerHTML = `
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Une erreur est survenue lors de la création de la commande
                <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="this.parentElement.remove();"></button>
            `;
            document.body.appendChild(alertDiv);
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        });
    });
    
    // Product search
    document.getElementById('product-search').addEventListener('input', function() {
        const query = this.value;
        
        if (query.length >= 2) {
            fetch(`{{ route('pos.search.products') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(products => {
                    // Clear grid
                    const grid = document.getElementById('products-grid');
                    grid.innerHTML = '';
                    
                    // Add found products
                    products.forEach(product => {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 col-sm-4 col-6';
                        col.innerHTML = `
                            <div class="card product-card h-100" data-product-id="${product.id}" data-product-name="${product.name}" data-product-price="${product.price}">
                                <img src="${product.image_url || '/storage/products/default.jpg'}" onerror="this.src='/images/no-image.jpg'" alt="${product.name}" class="card-img-top" style="height: 120px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <h6 class="card-title small mb-1">${product.name.substring(0, 20)}</h6>
                                    <p class="card-text small text-muted mb-1">${product.sku || 'N/A'}</p>
                                    <p class="card-text fw-bold text-primary">${parseFloat(product.price).toFixed(3)} TND</p>
                                </div>
                            </div>
                        `;
                        
                        grid.appendChild(col);
                        
                        // Add click event
                        col.querySelector('.product-card').addEventListener('click', function() {
                            addToCart(product.id, product.name, parseFloat(product.price));
                        });
                    });
                });
        } else if (query.length === 0) {
            // Reload default products when search is cleared
            location.reload();
        }
    });
});
</script>
@endpush