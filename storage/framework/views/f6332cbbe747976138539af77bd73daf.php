<?php
    $badge_text = $content['badge_text'] ?? 'Premium';
    // Logic to fetch specifically selected premium categories would go here
    // For now, we take 4 random categories as a placeholder
    $premium_categories = $shop->products()->distinct()->pluck('category')->filter()->shuffle()->take(4);
?>

<div class="container mb-5">
    <div class="row g-4">
        <?php $__currentLoopData = $premium_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm overflow-hidden position-relative">
                    <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark">
                        <i class="bi bi-star-fill me-1"></i> <?php echo e($badge_text); ?>

                    </span>
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                        <i class="bi bi-tag-fill text-muted display-4"></i>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold"><?php echo e($category); ?></h5>
                        <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain, 'category' => $category])); ?>" class="btn btn-sm btn-outline-primary mt-2">Découvrir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\shop\components\premium_categories.blade.php ENDPATH**/ ?>