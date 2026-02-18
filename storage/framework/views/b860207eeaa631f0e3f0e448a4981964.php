

<?php $__env->startSection('title', $product->name . ' - ' . $shop->name); ?>

<?php $__env->startSection('content'); ?>
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #f59e0b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            background: #f9fafb;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        /* Breadcrumb */
        .breadcrumb-section {
            background: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .breadcrumb {
            margin: 0;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        /* Product Gallery */
        .product-gallery {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
            position: sticky;
            top: 100px;
        }

        .main-image-wrapper {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            background: #f8f9fa;
            margin-bottom: 1rem;
        }

        .main-image {
            width: 100%;
            height: 500px;
            object-fit: contain;
            cursor: zoom-in;
        }

        .product-badge-large {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--accent-color);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 0.95rem;
            z-index: 10;
        }

        .thumbnail-gallery {
            display: flex;
            gap: 0.75rem;
            overflow-x: auto;
            padding: 0.5rem 0;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        /* Product Info */
        .product-info {
            background: white;
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
        }

        .product-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .product-meta {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .meta-item i {
            color: var(--primary-color);
        }

        .product-price-section {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .product-price {
            font-size: 3rem;
            font-weight: 900;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .price-label {
            color: var(--text-light);
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stock-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .stock-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stock-icon.in-stock {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .stock-icon.out-of-stock {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        /* Product Description */
        .product-description {
            margin: 2rem 0;
        }

        .description-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .description-content {
            color: var(--text-light);
            line-height: 1.8;
            font-size: 1.05rem;
        }

        /* Quantity Selector */
        .quantity-selector {
            margin: 2rem 0;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .quantity-label {
            font-weight: 600;
            font-size: 1.05rem;
            margin-bottom: 0.75rem;
            display: block;
        }

        .quantity-input-group {
            display: flex;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
            width: fit-content;
        }

        .quantity-btn {
            background: white;
            border: none;
            padding: 0.75rem 1.25rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .quantity-input {
            border: none;
            width: 80px;
            text-align: center;
            font-size: 1.25rem;
            font-weight: 700;
            border-left: 2px solid var(--border-color);
            border-right: 2px solid var(--border-color);
        }

        .quantity-input:focus {
            outline: none;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-add-cart {
            flex: 1;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 10px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }

        .btn-wishlist {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-wishlist:hover {
            transform: scale(1.1);
        }

        /* Product Features */
        .product-features {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 2rem 0;
        }

        .feature-item {
            display: flex;
            align-items: start;
            gap: 1rem;
            padding: 0.75rem 0;
        }

        .feature-item:not(:last-child) {
            border-bottom: 1px solid var(--border-color);
        }

        .feature-icon {
            width: 35px;
            height: 35px;
            background: var(--primary-color);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Tabs */
        .product-tabs {
            margin-top: 3rem;
        }

        .nav-tabs {
            border-bottom: 2px solid var(--border-color);
        }

        .nav-tabs .nav-link {
            border: none;
            color: var(--text-light);
            font-weight: 600;
            padding: 1rem 2rem;
            position: relative;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background: transparent;
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-color);
        }

        .tab-content {
            padding: 2rem 0;
        }

        /* Related Products */
        .related-products {
            margin-top: 4rem;
            padding: 3rem 0;
            background: white;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .product-card-small {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .product-card-small:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .product-card-small img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-card-small .card-body {
            padding: 1.25rem;
        }

        .product-card-small .product-name {
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-card-small .product-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        .social-link {
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
        }

        .social-link:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-title {
                font-size: 1.75rem;
            }
            
            .product-price {
                font-size: 2.25rem;
            }
            
            .main-image {
                height: 350px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn-wishlist {
                width: 100%;
                height: 50px;
            }

            .product-gallery {
                position: static;
            }
        }
    </style>
</head>
<body>
   

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

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-uppercase mb-4 fw-bold"><?php echo e($shop->name); ?></h5>
                    <?php if($shop->description): ?>
                        <p class="mb-3"><?php echo e(Str::limit($shop->description, 150)); ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h5 class="text-uppercase mb-4 fw-bold">Contact</h5>
                    <?php if($shop->contact_email): ?>
                        <p class="mb-3">
                            <i class="bi bi-envelope me-2"></i> 
                            <a href="mailto:<?php echo e($shop->contact_email); ?>" class="text-white text-decoration-none">
                                <?php echo e($shop->contact_email); ?>

                            </a>
                        </p>
                    <?php endif; ?>
                    <?php if($shop->contact_phone): ?>
                        <p class="mb-3">
                            <i class="bi bi-telephone me-2"></i> 
                            <a href="tel:<?php echo e($shop->contact_phone); ?>" class="text-white text-decoration-none">
                                <?php echo e($shop->contact_phone); ?>

                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h5 class="text-uppercase mb-4 fw-bold">Suivez-nous</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php if($shop->settings && $shop->settings->facebook_url): ?>
                            <a href="<?php echo e($shop->settings->facebook_url); ?>" target="_blank" class="social-link">
                                <i class="bi bi-facebook"></i>
                            </a>
                        <?php endif; ?>
                        <?php if($shop->settings && $shop->settings->instagram_url): ?>
                            <a href="<?php echo e($shop->settings->instagram_url); ?>" target="_blank" class="social-link">
                                <i class="bi bi-instagram"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row mt-5 pt-4 border-top border-secondary">
                <div class="col-md-12 text-center">
                    <p class="mb-2">&copy; <?php echo e(date('Y')); ?> <?php echo e($shop->name); ?>. Tous droits réservés.</p>
                    <p class="mb-0 text-muted"><small>Propulsé par <strong>Shoopino</strong></small></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Quantity controls
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
                    // Show success message
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="bi bi-check-circle me-2"></i>Ajouté au panier !';
                    button.classList.add('btn-success');
                    button.classList.remove('btn-primary');
                    
                    // Update cart count in navigation
                    document.querySelectorAll('.badge.bg-danger.ms-1').forEach(badge => {
                        badge.textContent = data.cart_count;
                    });
                    
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.classList.remove('btn-success');
                        button.classList.add('btn-primary');
                    }, 2000);
                } else {
                    alert(data.message || 'Erreur lors de l\'ajout au panier');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur s\'est produite lors de l\'ajout au panier');
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
<?php echo $__env->make('shop.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\shop\product-show.blade.php ENDPATH**/ ?>