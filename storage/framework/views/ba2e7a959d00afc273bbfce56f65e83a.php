<?php
    $style = $content['style'] ?? 'grid';
    $categoriesList = $categories ?? collect();
    
?>

<div class="container mb-5">
    <?php if(isset($content['title'])): ?>
        <h2 class="text-center mb-4"><?php echo e($content['title']); ?></h2>
    <?php endif; ?>

    <div class="row <?php echo e($style === 'slider' ? 'flex-nowrap overflow-auto pb-3' : ''); ?>">
        <?php $__empty_1 = true; $__currentLoopData = $categoriesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="<?php echo e($style === 'grid' ? 'col-md-3 col-6' : 'col-md-2 col-4'); ?> mb-4">
                <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain, 'category' => $category->slug])); ?>" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm border-0 text-center hover-lift overflow-hidden position-relative">
                        <div class="card-body p-3">
                            <?php if($category->image): ?>
                                <div class="rounded-circle overflow-hidden mx-auto mb-2 d-inline-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
                                    <img src="<?php echo e(Storage::url($category->image)); ?>" alt="<?php echo e($category->name); ?>" class="w-100 h-100 object-fit-cover">
                                </div>
                            <?php elseif($category->icon): ?>
                                <div class="rounded-circle overflow-hidden mx-auto mb-2 d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10" style="width: 60px; height: 60px;">
                                    <img src="<?php echo e(Storage::url($category->icon)); ?>" alt="<?php echo e($category->name); ?>" class="w-100 h-100 object-fit-contain p-1">
                                </div>
                            <?php else: ?>
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                    <i class="bi bi-tag text-primary h3 mb-0"></i>
                                </div>
                            <?php endif; ?>
                            <h6 class="card-title mb-0 small"><?php echo e($category->name); ?></h6>
                            
                            <!-- Product count badge -->
                            <?php
                                $productCount = $category->products()->where('is_active', true)->count();
                            ?>
                            <?php if($productCount > 0): ?>
                                <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-primary mt-2 me-2">
                                    <?php echo e($productCount); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center text-muted w-100">Aucune catégorie trouvée.</p>
        <?php endif; ?>
    </div>
</div>

<style>
.hover-lift { transition: transform 0.2s; }
.hover-lift:hover { transform: translateY(-5px); }
</style>
<?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\shop\components\categories.blade.php ENDPATH**/ ?>