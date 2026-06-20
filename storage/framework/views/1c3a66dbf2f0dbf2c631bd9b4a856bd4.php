<?php $__env->startSection('title', $product->name . ' - ' . $shop->name); ?>

<?php $__env->startSection('content'); ?>
    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain])); ?>">
                            <i class="bi bi-house-door me-1"></i>Accueil
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain])); ?>#products">Produits</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e($product->name); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Product Section -->
    <div class="container mb-5">
        <div class="row g-4">
            <!-- Product Gallery -->
            <div class="col-lg-6">
                <div class="product-gallery">
                    <div class="main-image-wrapper">
                        <?php if($product->image): ?>
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                 class="main-image" 
                                 id="mainImage"
                                 alt="<?php echo e($product->name); ?>">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center" style="height: 500px; background: #f8f9fa;">
                                <i class="bi bi-image text-muted" style="font-size: 6rem;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($product->isInStock()): ?>
                            <span class="product-badge-large bg-success">
                                <i class="bi bi-check-circle me-1"></i>En stock
                            </span>
                        <?php else: ?>
                            <span class="product-badge-large bg-danger">
                                <i class="bi bi-x-circle me-1"></i>Rupture de stock
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($product->images): ?>
                    <div class="thumbnail-gallery">
                        <?php if($product->image): ?>
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                 class="thumbnail active" 
                                 onclick="changeMainImage(this.src)"
                                 alt="<?php echo e($product->name); ?>">
                        <?php endif; ?>
                        
                        <?php $__currentLoopData = json_decode($product->images, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e(asset('storage/' . $image)); ?>" 
                                 class="thumbnail" 
                                 onclick="changeMainImage(this.src)"
                                 alt="<?php echo e($product->name); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <h1 class="product-title"><?php echo e($product->name); ?></h1>
                    
                    <div class="product-meta">
                        <?php if($product->sku): ?>
                        <div class="meta-item">
                            <i class="bi bi-upc-scan"></i>
                            <span>SKU: <strong><?php echo e($product->sku); ?></strong></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($product->brand): ?>
                        <div class="meta-item">
                            <i class="bi bi-tag"></i>
                            <span>Marque: <strong><?php echo e($product->brand); ?></strong></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($product->reference): ?>
                        <div class="meta-item">
                            <i class="bi bi-hash"></i>
                            <span>Réf: <strong><?php echo e($product->reference); ?></strong></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if($product->short_description): ?>
                    <div class="alert alert-info border-0" style="background: #eff6ff;">
                        <i class="bi bi-info-circle me-2"></i><?php echo $product->short_description; ?>

                    </div>
                    <?php endif; ?>

                    <div class="product-price-section">
                        <div class="price-label">Prix</div>
                        <div class="product-price"><?php echo e($product->formatted_price); ?></div>
                        
                        <div class="stock-info">
                            <?php if($product->isInStock()): ?>
                                <div class="stock-icon in-stock">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-success">Disponible en stock</div>
                                    <small class="text-muted"><?php echo e($product->stock); ?> unité(s) disponible(s)</small>
                                </div>
                            <?php else: ?>
                                <div class="stock-icon out-of-stock">
                                    <i class="bi bi-x-circle-fill"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-danger">Rupture de stock</div>
                                    <small class="text-muted">Produit temporairement indisponible</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($product->isInStock()): ?>
                    <div class="quantity-selector">
                        <label class="quantity-label">Quantité</label>
                        <div class="quantity-controls">
                            <div class="quantity-input-group">
                                <button class="quantity-btn" onclick="decreaseQuantity()">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" 
                                       id="quantity" 
                                       class="quantity-input" 
                                       value="1" 
                                       min="1" 
                                       max="<?php echo e($product->stock); ?>"
                                       readonly>
                                <button class="quantity-btn" onclick="increaseQuantity()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="action-buttons" style="color: ;">
                        <button class="btn btn-primary btn-add-cart">
                            <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                        </button>
                        <button class="btn btn-outline-danger btn-wishlist" title="Ajouter aux favoris">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>
                    
                    <!-- Toast container for notifications -->
                    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                        <div id="cartToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <span id="toastMessage">Produit ajouté au panier avec succès!</span>
                                </div>
                                
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Ce produit est actuellement en rupture de stock. Veuillez nous contacter pour plus d'informations.
                    </div>
                    <?php endif; ?>

                    <div class="product-features">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div>
                                <strong>Garantie qualité</strong>
                                <div class="text-muted small">Produits authentiques et certifiés</div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-truck"></i>
                            </div>
                            <div>
                                <strong>Livraison rapide</strong>
                                <div class="text-muted small">Expédition sous 24-48h</div>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="bi bi-arrow-clockwise"></i>
                            </div>
                            <div>
                                <strong>Retour facile</strong>
                                <div class="text-muted small">30 jours pour changer d'avis</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="product-tabs mt-5">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#description" type="button">
                        <i class="bi bi-file-text me-2"></i>Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#specifications" type="button">
                        <i class="bi bi-list-ul me-2"></i>Caractéristiques
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#delivery" type="button">
                        <i class="bi bi-truck me-2"></i>Livraison
                    </button>
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane fade show active" id="description">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="description-title">Description du produit</h3>
                            <?php if($product->description): ?>
                                <div class="description-content">
                                    <?php echo $product->description; ?>

                                </div>
                            <?php else: ?>
                                <p class="text-muted">Aucune description disponible pour ce produit.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="specifications">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="description-title">Caractéristiques techniques</h3>
                            <table class="table table-striped">
                                <tbody>
                                    <?php if($product->reference): ?>
                                    <tr>
                                        <td class="fw-bold" style="width: 200px;">Référence</td>
                                        <td><?php echo e($product->reference); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($product->sku): ?>
                                    <tr>
                                        <td class="fw-bold">SKU</td>
                                        <td><?php echo e($product->sku); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($product->brand): ?>
                                    <tr>
                                        <td class="fw-bold">Marque</td>
                                        <td><?php echo e($product->brand); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($product->supplier): ?>
                                    <tr>
                                        <td class="fw-bold">Fournisseur</td>
                                        <td><?php echo e($product->supplier); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if($product->barcode): ?>
                                    <tr>
                                        <td class="fw-bold">Code-barres</td>
                                        <td><?php echo e($product->barcode); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="delivery">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="description-title">Informations de livraison</h3>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="feature-icon">
                                            <i class="bi bi-truck"></i>
                                        </div>
                                        <div>
                                            <h5>Livraison standard</h5>
                                            <p class="text-muted mb-0">Délai de livraison : 2-5 jours ouvrables</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="feature-icon">
                                            <i class="bi bi-box-seam"></i>
                                        </div>
                                        <div>
                                            <h5>Emballage sécurisé</h5>
                                            <p class="text-muted mb-0">Tous nos produits sont soigneusement emballés</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="feature-icon">
                                            <i class="bi bi-geo-alt"></i>
                                        </div>
                                        <div>
                                            <h5>Suivi de commande</h5>
                                            <p class="text-muted mb-0">Suivez votre colis en temps réel</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="feature-icon">
                                            <i class="bi bi-credit-card"></i>
                                        </div>
                                        <div>
                                            <h5>Paiement sécurisé</h5>
                                            <p class="text-muted mb-0">Transactions 100% sécurisées</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if(isset($relatedProducts) && $relatedProducts->count() > 0): ?>
    <div class="related-products">
        <div class="container">
            <h2 class="section-title">Produits similaires</h2>
            <div class="row g-4">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product-card-small">
                        <a href="<?php echo e(route('shop.product', ['subdomain' => $shop->subdomain, 'id' => $relatedProduct->id])); ?>">
                            <?php if($relatedProduct->image): ?>
                                <img src="<?php echo e(asset('storage/' . $relatedProduct->image)); ?>" alt="<?php echo e($relatedProduct->name); ?>">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                        </a>
                        <div class="card-body">
                            <h5 class="product-name">
                                <a href="<?php echo e(route('shop.product', ['subdomain' => $shop->subdomain, 'id' => $relatedProduct->id])); ?>" 
                                   class="text-decoration-none text-dark">
                                    <?php echo e($relatedProduct->name); ?>

                                </a>
                            </h5>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="product-price"><?php echo e($relatedProduct->formatted_price); ?></span>
                                <?php if($relatedProduct->isInStock()): ?>
                                    <span class="badge bg-success-subtle text-success">En stock</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger">Rupture</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Quantity controls
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
        function increaseQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            const min = parseInt(input.getAttribute('min'));
            const current = parseInt(input.value);
            if (current > min) {
                input.value = current - 1;
            }
        }

        // Change main image
        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Add to cart functionality
        document.querySelector('.btn-add-cart')?.addEventListener('click', function() {
            const quantity = document.getElementById('quantity')?.value || 1;
            const productId = <?php echo e($product->id); ?>; // Assuming the product ID is available
            const productName = '<?php echo e($product->name); ?>';
            const button = this;
            
            // Make AJAX request to add to cart
            fetch('<?php echo e(route("shop.cart.add", ["subdomain" => $shop->subdomain])); ?>', {
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
                    // Update toast message
                    const toastMessage = document.getElementById('toastMessage');
                    toastMessage.innerHTML = `<i class="bi bi-check-circle me-2"></i>${quantity} x ${productName} ajouté(s) au panier!`;
                    
                    // Show toast
                    const toastElement = document.getElementById('cartToast');
                    const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
                    toast.show();
                    
                    // Update cart count with smooth animation (use actual count from server)
                    const cartCountValue = document.getElementById('cart-count-value');
                    if (cartCountValue && data.cart_count !== undefined) {
                        // Animate the change smoothly
                        cartCountValue.style.transform = 'scale(1.3)';
                        cartCountValue.style.opacity = '0.7';
                        
                        setTimeout(() => {
                            cartCountValue.textContent = data.cart_count;
                            cartCountValue.style.transform = 'scale(1)';
                            cartCountValue.style.opacity = '1';
                        }, 150);
                    }
                    
                    // Show success message on button
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="bi bi-check-circle me-2"></i>Ajouté au panier !';
                    button.classList.add('btn-success');
                    button.classList.remove('btn-primary');
                    
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.classList.remove('btn-success');
                        button.classList.add('btn-primary');
                    }, 2000);
                } else {
                    // Show error toast
                    const toastElement = document.getElementById('cartToast');
                    toastElement.classList.remove('bg-success');
                    toastElement.classList.add('bg-danger');
                    const toastMessage = document.getElementById('toastMessage');
                    toastMessage.innerHTML = `<i class="bi bi-x-circle me-2"></i>${data.message || 'Erreur lors de l\'ajout au panier'}`;
                    const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
                    toast.show();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Show error toast
                const toastElement = document.getElementById('cartToast');
                toastElement.classList.remove('bg-success');
                toastElement.classList.add('bg-danger');
                const toastMessage = document.getElementById('toastMessage');
                toastMessage.innerHTML = '<i class="bi bi-x-circle me-2"></i>Une erreur s\'est produite';
                const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
                toast.show();
            });
        });

        // Wishlist functionality
        document.querySelector('.btn-wishlist')?.addEventListener('click', function() {
            this.classList.toggle('btn-outline-danger');
            this.classList.toggle('btn-danger');
            
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-heart');
            icon.classList.toggle('bi-heart-fill');
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('shop.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/shop/product-show.blade.php ENDPATH**/ ?>