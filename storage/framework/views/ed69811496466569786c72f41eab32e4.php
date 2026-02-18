<?php
    $reviews = $content['reviews'] ?? [];
    $style = $content['style'] ?? 'slider';
?>

<div class="container mb-5">
    <h2 class="text-center mb-4"><?php echo e($content['title'] ?? 'Avis Clients'); ?></h2>
    
    <?php if($style === 'slider'): ?>
    <div id="reviews-<?php echo e($id); ?>" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php $__currentLoopData = array_chunk($reviews, 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($review['text']) && !empty($review['text'])): ?>
                    <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                        <div class="card border-0 text-center">
                            <div class="card-body">
                                <div class="text-warning mb-2" style="font-size: 1.2rem;">
                                    <?php for($i = 0; $i < ($review['rating'] ?? 5); $i++): ?>
                                        <i class="bi bi-star-fill"></i>
                                    <?php endfor; ?>
                                </div>
                                <blockquote class="blockquote mb-4">
                                    <p>"<?php echo e($review['text']); ?>"</p>
                                </blockquote>
                                <figcaption class="blockquote-footer">
                                    <?php echo e($review['name'] ?? 'Client'); ?>

                                </figcaption>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#reviews-<?php echo e($id); ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#reviews-<?php echo e($id); ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
        </button>
    </div>
    <?php else: ?>
    <div class="row">
        <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($review['text']) && !empty($review['text'])): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="text-warning mb-2">
                            <?php for($i = 0; $i < ($review['rating'] ?? 5); $i++): ?>
                                <i class="bi bi-star-fill"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="card-text">"<?php echo e($review['text']); ?>"</p>
                        <h6 class="card-subtitle mt-2 text-muted">- <?php echo e($review['name'] ?? 'Client'); ?></h6>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\shop\components\reviews.blade.php ENDPATH**/ ?>