<?php $__env->startSection('title', 'Recherche - ' . $shop->name); ?>

<?php $__env->startSection('content'); ?>
<div class="search-header">
    <div class="container">
        <h1 class="text-center mb-0">
            <i class="bi bi-search me-2"></i>
            <span class="search-query">Résultats pour "<?php echo e($query); ?>"</span>
        </h1>
        <p class="text-center search-count mt-2">
            <?php echo e($products->count()); ?> résultat(s) trouvé(s)
        </p>
    </div>
</div>

<div class="container search-results-container">
    <?php if($products->count() > 0): ?>
        <div class="row g-4">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <?php if($product->image): ?>
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                 class="product-image" 
                                 alt="<?php echo e($product->name); ?>">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-body">
                        <h5 class="product-title"><?php echo e($product->name); ?></h5>
                        
                        <?php if($product->short_description): ?>
                            <p class="product-description"><?php echo Str::limit($product->short_description, 100); ?></p>
                        <?php elseif($product->description): ?>
                            <p class="product-description"><?php echo Str::limit($product->description, 100); ?></p>
                        <?php endif; ?>
                        
                        <div class="product-price"><?php echo e($product->formatted_price); ?></div>
                        
                        <div class="d-grid">
                            <a href="<?php echo e(route('shop.product', ['subdomain' => $shop->subdomain, 'id' => $product->id])); ?>" 
                               class="btn btn-primary">
                                <i class="bi bi-eye me-1"></i>Voir le produit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="no-results">
            <i class="bi bi-search"></i>
            <h3>Aucun résultat trouvé</h3>
            <p class="text-muted">Nous n'avons trouvé aucun produit correspondant à votre recherche "<?php echo e($query); ?>"</p>
            <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain])); ?>" class="btn btn-primary">
                <i class="bi bi-arrow-left me-1"></i>Retour à l'accueil
            </a>
        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('shop.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/shop/search-results.blade.php ENDPATH**/ ?>