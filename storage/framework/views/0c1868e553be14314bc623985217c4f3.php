    

<?php $__env->startSection('title', $page->title . ' - ' . $shop->name); ?>

<?php $__env->startSection('content'); ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain])); ?>"><?php echo e($shop->name); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php $__currentLoopData = $shop->pages()->where('is_active', true)->orderBy('order')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($p->id === $page->id ? 'active' : ''); ?>" href="<?php echo e(route('shop.page', ['subdomain' => $shop->subdomain, 'slug' => $p->slug])); ?>"><?php echo e($p->title); ?></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('shop.cart', ['subdomain' => $shop->subdomain])); ?>">
                            <i class="bi bi-cart3 me-1"></i> Panier
                            <span class="badge bg-danger ms-1"><?php echo e(\App\Models\Cart::getCartCount(auth()->id())); ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1><?php echo e($page->title); ?></h1>
        <div class="mt-4">
            <?php echo $page->content; ?>

        </div>

        <?php if(isset($products) && $products->count() > 0): ?>
            <div class="mt-5">
                <h2 class="mb-4">Nos produits</h2>
                <div class="row">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if($product->image): ?>
                                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo e($product->name); ?></h5>
                                <p class="card-text text-muted flex-grow-1">
                                    <?php if($product->description): ?>
                                        <?php echo e(strlen($product->description) > 100 ? substr($product->description, 0, 100) . '...' : $product->description); ?>

                                    <?php else: ?>
                                        <em>Aucune description</em>
                                    <?php endif; ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="h5 text-primary mb-0"><?php echo e($product->formatted_price); ?></span>
                                    <?php if($product->isInStock()): ?>
                                        <span class="badge bg-success">En stock (<?php echo e($product->stock); ?>)</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Rupture de stock</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php elseif(isset($products) && $products->count() === 0): ?>
            <div class="mt-5">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Aucun produit disponible pour le moment.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shop.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\shop\page.blade.php ENDPATH**/ ?>