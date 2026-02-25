<?php $__env->startSection('title', $shop->name); ?>

<?php $__env->startSection('content'); ?>
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
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .nav-link {
            font-weight: 500;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: white;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0;
            margin-bottom: 60px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>');
            animation: float 20s linear infinite;
        }

        @keyframes float {
            from { transform: translateY(0); }
            to { transform: translateY(-100px); }
        }

        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .hero-description {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .hero-buttons .btn {
            margin: 0.5rem;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .hero-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        /* Product Cards */
        .product-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }

        .product-image-wrapper {
            position: relative;
            overflow: hidden;
            height: 280px;
            background: #f8f9fa;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.1);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            z-index: 2;
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: flex-end;
            padding: 20px;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .quick-view-btn {
            background: white;
            color: var(--primary-color);
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .quick-view-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .product-body {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
            min-height: 50px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-description {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .stock-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Section Headers */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
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
            border-radius: 2px;
        }

        .section-subtitle {
            color: var(--text-light);
            font-size: 1.1rem;
        }

        /* Features Section */
        .features-section {
            background: #f8f9fa;
            padding: 60px 0;
            margin: 60px 0;
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: white;
            padding-top: 60px;
            margin-top: 80px;
        }

        footer a {
            color: rgba(255,255,255,0.8);
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: white;
        }

        .social-link {
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.75rem;
            }
            
            .product-image-wrapper {
                height: 220px;
            }
        }

        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
  

    <!-- Hero Section -->
    <!-- <div class="hero-section">
        <div class="container">
            <div class="hero-content fade-in-up">
                <?php if($shop->logo): ?>
                    <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($shop->logo)); ?>" alt="<?php echo e($shop->name); ?>" class="mb-4" style="max-height: 120px;">
                <?php endif; ?>
                <h1 class="hero-title">Bienvenue sur <?php echo e($shop->name); ?></h1>
                
                <div class="hero-buttons">
                    <a href="#products" class="btn btn-light btn-lg">
                        <i class="bi bi-bag me-2"></i>Découvrir nos produits
                    </a>
                    <a href="#contact" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-envelope me-2"></i>Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </div> -->
    <?php $components = $shop->components()->where('type', '!=', 'banner')->get(); ?>
       <?php $__currentLoopData = $components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('shop.components.' . $component->type, [
            'id' => $component->id,
            'content' => $component->content,
            'shop' => $shop,
            'categories' => $shop->categories()->where('is_active', true)->whereNull('parent_id')->get()
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

 

    <!-- Dynamic Components Builder -->




    <!-- Products Section -->
    <div class="container" id="products">
        <?php if(isset($products) && $products->count() > 0): ?>
            <div class="section-header">
                <h2 class="section-title">
                    <?php if(isset($currentCategory) && $currentCategory): ?>
                        <?php echo e($currentCategory->name); ?>

                    <?php else: ?>
                        Nos produits
                    <?php endif; ?>
                </h2>
                <p class="section-subtitle">
                    <?php if(isset($currentCategory) && $currentCategory): ?>
                        Tous les produits de cette catégorie
                    <?php else: ?>
                        Découvrez notre sélection de produits de qualité
                    <?php endif; ?>
                </p>
            </div>
            
            <div class="row g-4">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-4 col-sm-6 fade-in-up" style="animation-delay: <?php echo e($loop->index * 0.1); ?>s">
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            <?php if($product->image): ?>
                                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                     class="product-image" 
                                     alt="<?php echo e($product->name); ?>">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                    <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($product->isInStock()): ?>
                                <span class="product-badge bg-success">En stock</span>
                            <?php else: ?>
                                <span class="product-badge bg-danger">Rupture</span>
                            <?php endif; ?>
                            
                            <div class="product-overlay">
                                <a href="<?php echo e(route('shop.product', ['subdomain' => $shop->subdomain, 'id' => $product->id])); ?>">
    Voir le produit
</a>
                            </div>
                        </div>
                        
                        <div class="product-body">
                            <h5 class="product-title"><?php echo e($product->name); ?></h5>
                            
                            <?php if($product->short_description): ?>
                                <p class="product-description"><?php echo $product->short_description; ?></p>
                            <?php elseif($product->description): ?>
                                <p class="product-description"><?php echo $product->description; ?></p>
                            <?php else: ?>
                                <p class="product-description text-muted"><em>Aucune description</em></p>
                            <?php endif; ?>
                            
                            <div class="product-price"><?php echo e($product->formatted_price); ?></div>
                            
                            <div class="product-footer">
                                <?php if($product->isInStock()): ?>
                                    <span class="stock-badge bg-success-subtle text-success">
                                        <i class="bi bi-check-circle me-1"></i><?php echo e($product->stock); ?> disponible(s)
                                    </span>
                                <?php else: ?>
                                    <span class="stock-badge bg-danger-subtle text-danger">
                                        <i class="bi bi-x-circle me-1"></i>Rupture
                                    </span>
                                <?php endif; ?>
                                
                                <div class="d-flex gap-2">
                                    <?php if($product->isInStock()): ?>
                                        <button 
                                            class="btn btn-sm btn-primary btn-add-cart-list"
                                            data-product-id="<?php echo e($product->id); ?>">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('shop.product', ['subdomain' => $shop->subdomain, 'id' => $product->id])); ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

       <!-- Features Section -->
    <div class="features-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h3 class="feature-title">Livraison rapide</h3>
                        <p class="text-muted">Livraison à domicile en 24-48h</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="feature-title">Paiement sécurisé</h3>
                        <p class="text-muted">Transactions 100% sécurisées</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-arrow-clockwise"></i>
                        </div>
                        <h3 class="feature-title">Retour gratuit</h3>
                        <p class="text-muted">30 jours pour changer d'avis</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h3 class="feature-title">Support 24/7</h3>
                        <p class="text-muted">Service client disponible</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="row g-4">
                <!-- Company Info -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-uppercase mb-4 fw-bold"><?php echo e($shop->name); ?></h5>
                    <?php if($shop->description): ?>
                        <p class="mb-3"><?php echo e(Str::limit($shop->description, 150)); ?></p>
                    <?php endif; ?>
                    <?php if($shop->company_name): ?>
                        <p class="mb-2"><strong><?php echo e($shop->company_name); ?></strong></p>
                    <?php endif; ?>
                    <?php if($shop->tax_id): ?>
                        <p class="mb-0"><small>MF: <?php echo e($shop->tax_id); ?></small></p>
                    <?php endif; ?>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-uppercase mb-4 fw-bold">Contact</h5>
                    <?php if($shop->contact_email): ?>
                        <p class="mb-3">
                            <i class="bi bi-envelope me-2"></i> 
                            <a href="mailto:<?php echo e($shop->contact_email); ?>" class="text-decoration-none">
                                <?php echo e($shop->contact_email); ?>

                            </a>
                        </p>
                    <?php endif; ?>
                    <?php if($shop->contact_phone): ?>
                        <p class="mb-3">
                            <i class="bi bi-telephone me-2"></i> 
                            <a href="tel:<?php echo e($shop->contact_phone); ?>" class="text-decoration-none">
                                <?php echo e($shop->contact_phone); ?>

                            </a>
                        </p>
                    <?php endif; ?>
                    <?php if($shop->street || $shop->city): ?>
                        <p class="mb-0">
                            <i class="bi bi-geo-alt me-2"></i> 
                            <?php if($shop->street): ?><?php echo e($shop->street); ?><?php endif; ?>
                            <?php if($shop->city): ?>, <?php echo e($shop->city); ?><?php endif; ?>
                            <?php if($shop->state): ?>, <?php echo e($shop->state); ?><?php endif; ?>
                            <?php if($shop->postal_code): ?> <?php echo e($shop->postal_code); ?><?php endif; ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Social Media -->
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
                        <?php if($shop->settings && $shop->settings->tiktok_url): ?>
                            <a href="<?php echo e($shop->settings->tiktok_url); ?>" target="_blank" class="social-link">
                                <i class="bi bi-tiktok"></i>
                            </a>
                        <?php endif; ?>
                        <?php if($shop->settings && $shop->settings->twitter_url): ?>
                            <a href="<?php echo e($shop->settings->twitter_url); ?>" target="_blank" class="social-link">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                        <?php endif; ?>
                        <?php if($shop->settings && $shop->settings->youtube_url): ?>
                            <a href="<?php echo e($shop->settings->youtube_url); ?>" target="_blank" class="social-link">
                                <i class="bi bi-youtube"></i>
                            </a>
                        <?php endif; ?>
                        <?php if($shop->settings && $shop->settings->whatsapp_number): ?>
                            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $shop->settings->whatsapp_number)); ?>" target="_blank" class="social-link">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="row mt-5 pt-4 border-top border-secondary">
                <div class="col-md-12 text-center">
                    <p class="mb-2">&copy; <?php echo e(date('Y')); ?> <?php echo e($shop->name); ?>. Tous droits réservés.</p>
                    <p class="mb-0 text-muted"><small>Propulsé par <strong>Shoopino</strong></small></p>
                </div>
            </div>
        </div>
        <div class="pb-3"></div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in-up').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            observer.observe(el);
        });

        // Add to cart from listing
        document.querySelectorAll('.btn-add-cart-list').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.productId;
                const btn = this;

                fetch('<?php echo e(route("shop.cart.add", ["subdomain" => $shop->subdomain])); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const originalHtml = btn.innerHTML;
                        btn.innerHTML = '<i class="bi bi-check-circle"></i>';
                        btn.classList.remove('btn-primary');
                        btn.classList.add('btn-success');

                        document.querySelectorAll('.badge.bg-danger.ms-1').forEach(badge => {
                            badge.textContent = data.cart_count;
                        });

                        setTimeout(() => {
                            btn.innerHTML = originalHtml;
                            btn.classList.remove('btn-success');
                            btn.classList.add('btn-primary');
                        }, 1500);
                    } else {
                        alert(data.message || 'Erreur lors de l\'ajout au panier');
                    }
                })
                .catch(() => {
                    alert('Une erreur s\'est produite lors de l\'ajout au panier');
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('shop.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/shop/index.blade.php ENDPATH**/ ?>