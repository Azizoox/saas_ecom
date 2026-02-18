

<?php $__env->startSection('title', 'Point de Vente - POS'); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php if($currentSession): ?>
                        <!-- Current Session Info -->
                        <div class="alert alert-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Caisse:</strong> <?php echo e($currentRegister->name); ?><br>
                                    <strong>Agent:</strong> <?php echo e($currentSession->user->getFullNameAttribute()); ?><br>
                                    <strong>Ouverte à:</strong> <?php echo e($currentSession->opened_at->format('d/m/Y H:i')); ?>

                                </div>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#closeRegisterModal">
                                    <i class="bi bi-cash-coin"></i> Fermer Caisse
                                </button>
                            </div>
                        </div>

                        <!-- Product Search and Cart -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" id="productSearch" class="form-control" placeholder="Rechercher un produit...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#createRegisterModal">
                                    <i class="bi bi-plus-circle"></i> Nouvelle Caisse
                                </button>
                            </div>
                        </div>

                        <!-- Products Grid -->
                        <div class="row" id="productsContainer">
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4 col-lg-3 mb-3 product-item" data-name="<?php echo e(strtolower($product->name)); ?>">
                                    <div class="card h-100 product-card" 
                                         data-id="<?php echo e($product->id); ?>" 
                                         data-name="<?php echo e($product->name); ?>" 
                                         data-price="<?php echo e($product->price); ?>"
                                         data-stock="<?php echo e($product->stock); ?>">
                                        <div class="card-body text-center">
                                            <h6 class="card-title"><?php echo e($product->name); ?></h6>
                                            <p class="card-text text-primary fw-bold">
                                                <?php echo e(number_format($product->price, 2, ',', ' ')); ?> TND
                                            </p>
                                            <small class="text-muted">Stock: <?php echo e($product->stock); ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Cart -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-cart me-2"></i>Panier
                                    <span id="cartItemCount" class="badge bg-primary float-end">0</span>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="cartItems">
                                    <p class="text-center text-muted">Aucun article ajouté</p>
                                </div>
                                
                                <hr>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nom du client</label>
                                            <input type="text" id="customerName" class="form-control" placeholder="Optionnel">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Remise (TND)</label>
                                            <input type="number" id="discount" class="form-control" min="0" step="0.01" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Méthode de paiement</label>
                                            <select id="paymentMethod" class="form-select">
                                                <option value="cash">Espèces</option>
                                                <option value="card">Carte</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Total</label>
                                            <div class="input-group">
                                                <span class="input-group-text">TND</span>
                                                <input type="text" id="totalAmount" class="form-control fw-bold" value="0.00" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button id="processOrderBtn" class="btn btn-success btn-lg" disabled>
                                        <i class="bi bi-check-circle me-2"></i>Valider la Commande
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- No Open Register -->
                        <div class="text-center py-5">
                            <i class="bi bi-cash-coin" style="font-size: 4rem; color: #6c757d;"></i>
                            <h3 class="mt-3">Aucune caisse ouverte</h3>
                            <p class="text-muted">Veuillez ouvrir une caisse pour commencer les ventes</p>
                            
                            <?php if($cashRegisters->count() > 0): ?>
                                <div class="row justify-content-center mt-4">
                                    <?php $__currentLoopData = $cashRegisters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $register): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo e($register->name); ?></h5>
                                                    <?php if($register->location): ?>
                                                        <p class="card-text text-muted"><?php echo e($register->location); ?></p>
                                                    <?php endif; ?>
                                                    <button type="button" class="btn btn-primary w-100" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#openRegisterModal"
                                                            data-register-id="<?php echo e($register->id); ?>"
                                                            data-register-name="<?php echo e($register->name); ?>">
                                                        <i class="bi bi-unlock me-2"></i>Ouvrir
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Aucune caisse enregistrée. Créez une caisse pour commencer.
                                </div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRegisterModal">
                                    <i class="bi bi-plus-circle me-2"></i>Créer une Caisse
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Panel - Quick Stats -->
        <div class="col-lg-4">
            <?php if($currentSession): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="bi bi-graph-up me-2"></i>Statistiques de la Session
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="text-muted small">Ventes Espèces</div>
                                    <div class="h5 text-success"><?php echo e(number_format($currentSession->cash_sales, 2, ',', ' ')); ?> TND</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="text-muted small">Ventes Carte</div>
                                    <div class="h5 text-primary"><?php echo e(number_format($currentSession->card_sales, 2, ',', ' ')); ?> TND</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-muted small">Total Ventes</div>
                            <div class="h4 text-dark"><?php echo e(number_format($currentSession->total_sales, 2, ',', ' ')); ?> TND</div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <div class="text-muted small">Fond de Caisse</div>
                            <div class="h5 text-info"><?php echo e(number_format($currentSession->opening_amount, 2, ',', ' ')); ?> TND</div>
                        </div>
                        <div class="text-center">
                            <div class="text-muted small">Attendu</div>
                            <div class="h5 text-warning"><?php echo e(number_format($currentSession->expected_amount, 2, ',', ' ')); ?> TND</div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>Actions Rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('pos.orders')); ?>" class="btn btn-outline-primary">
                            <i class="bi bi-list-check me-2"></i>Commandes POS
                        </a>
                        <a href="<?php echo e(route('pos.history')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-journal-text me-2"></i>Historique Caisse
                        </a>
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-info">
                            <i class="bi bi-box-seam me-2"></i>Gérer Produits
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Open Register Modal -->
<div class="modal fade" id="openRegisterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('pos.register.open')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Ouvrir Caisse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="cash_register_id" id="registerId">
                    <div class="mb-3">
                        <label class="form-label">Caisse</label>
                        <input type="text" class="form-control" id="registerName" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fond de caisse initial (TND)</label>
                        <input type="number" name="opening_amount" class="form-control" min="0" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ouvrir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Close Register Modal -->
<?php if($currentSession): ?>
<div class="modal fade" id="closeRegisterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('pos.register.close')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="session_id" value="<?php echo e($currentSession->id); ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Fermer Caisse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Veuillez compter l'argent dans la caisse
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Montant réel dans la caisse (TND)</label>
                        <input type="number" name="actual_amount" class="form-control" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes (optionnel)</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Résumé</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Attendu:</small>
                                    <div class="fw-bold"><?php echo e(number_format($currentSession->expected_amount, 2, ',', ' ')); ?> TND</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Ventes espèces:</small>
                                    <div class="fw-bold"><?php echo e(number_format($currentSession->cash_sales, 2, ',', ' ')); ?> TND</div>
                                </div>
                            </div>
                        </div>
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
<?php endif; ?>

<!-- Create Register Modal -->
<div class="modal fade" id="createRegisterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('pos.register.create')); ?>" method="POST">
                <?php echo csrf_field(); ?>
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
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Open Register Modal
    const openRegisterModal = document.getElementById('openRegisterModal');
    if (openRegisterModal) {
        openRegisterModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const registerId = button.getAttribute('data-register-id');
            const registerName = button.getAttribute('data-register-name');
            
            const registerIdInput = document.getElementById('registerId');
            const registerNameInput = document.getElementById('registerName');
            
            registerIdInput.value = registerId;
            registerNameInput.value = registerName;
        });
    }
    
    // Product search
    const productSearch = document.getElementById('productSearch');
    const productItems = document.querySelectorAll('.product-item');
    
    if (productSearch) {
        productSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            productItems.forEach(item => {
                const productName = item.getAttribute('data-name');
                if (productName.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
    
    // Cart functionality
    let cart = [];
    
    // Add product to cart
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productPrice = parseFloat(this.getAttribute('data-price'));
            const productStock = parseInt(this.getAttribute('data-stock'));
            
            // Check if product already in cart
            const existingItem = cart.find(item => item.id == productId);
            
            if (existingItem) {
                if (existingItem.quantity < productStock) {
                    existingItem.quantity++;
                } else {
                    alert('Stock insuffisant');
                    return;
                }
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    quantity: 1
                });
            }
            
            updateCart();
        });
    });
    
    // Update cart display
    function updateCart() {
        const cartItemsContainer = document.getElementById('cartItems');
        const cartItemCount = document.getElementById('cartItemCount');
        const totalAmount = document.getElementById('totalAmount');
        const processOrderBtn = document.getElementById('processOrderBtn');
        
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="text-center text-muted">Aucun article ajouté</p>';
            cartItemCount.textContent = '0';
            totalAmount.value = '0.00';
            processOrderBtn.disabled = true;
            return;
        }
        
        let html = '';
        let total = 0;
        
        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            
            html += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong>${item.name}</strong>
                        <div class="small text-muted">${item.quantity} × ${item.price.toFixed(2)} TND</div>
                    </div>
                    <div class="text-end">
                        <div>${itemTotal.toFixed(2)} TND</div>
                        <div>
                            <button class="btn btn-sm btn-outline-danger remove-item" data-id="${item.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
        
        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const finalTotal = Math.max(0, total - discount);
        
        html += `
            <hr>
            <div class="d-flex justify-content-between">
                <strong>Sous-total:</strong>
                <strong>${total.toFixed(2)} TND</strong>
            </div>
            <div class="d-flex justify-content-between">
                <strong>Remise:</strong>
                <strong class="text-danger">-${discount.toFixed(2)} TND</strong>
            </div>
            <div class="d-flex justify-content-between">
                <strong>Total:</strong>
                <strong class="text-success">${finalTotal.toFixed(2)} TND</strong>
            </div>
        `;
        
        cartItemsContainer.innerHTML = html;
        cartItemCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
        totalAmount.value = finalTotal.toFixed(2);
        processOrderBtn.disabled = false;
        
        // Remove item event
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                cart = cart.filter(item => item.id != productId);
                updateCart();
            });
        });
    }
    
    // Discount change
    document.getElementById('discount').addEventListener('input', updateCart);
    
    // Process order
    document.getElementById('processOrderBtn').addEventListener('click', function() {
        if (cart.length === 0) return;
        
        const customerName = document.getElementById('customerName').value;
        const paymentMethod = document.getElementById('paymentMethod').value;
        const discount = document.getElementById('discount').value;
        
        const formData = new FormData();
        formData.append('customer_name', customerName);
        formData.append('payment_method', paymentMethod);
        formData.append('discount', discount);
        
        cart.forEach((item, index) => {
            formData.append(`items[${index}][product_id]`, item.id);
            formData.append(`items[${index}][quantity]`, item.quantity);
        });
        
        fetch('<?php echo e(route("pos.order.create")); ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Commande ${data.order_number} créée avec succès! Total: ${data.total.toFixed(2)} TND`);
                cart = [];
                document.getElementById('customerName').value = '';
                document.getElementById('discount').value = '0';
                updateCart();
            } else {
                alert('Erreur: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la création de la commande');
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\pos\index.blade.php ENDPATH**/ ?>