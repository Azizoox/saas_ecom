<?php
    $slides = $content['slides'] ?? [];
    $options = $content['options'] ?? [];
?>

<?php if(count($slides) > 0): ?>
<div id="carousel-<?php echo e($id); ?>" class="carousel slide mb-5" data-bs-ride="<?php echo e(($options['autoplay'] ?? true) ? 'carousel' : 'false'); ?>">
    <?php if($options['pagination'] ?? true): ?>
    <div class="carousel-indicators">
        <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button type="button" data-bs-target="#carousel-<?php echo e($id); ?>" data-bs-slide-to="<?php echo e($index); ?>" class="<?php echo e($index === 0 ? 'active' : ''); ?>"></button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <div class="carousel-inner">
        <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($slide['image'])): ?>
            <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                <img src="<?php echo e(Storage::url($slide['image'])); ?>" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="<?php echo e($slide['title'] ?? ''); ?>">
                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                    <?php if(isset($slide['title'])): ?>
                        <h3><?php echo e($slide['title']); ?></h3>
                    <?php endif; ?>
                    <?php if(isset($slide['description'])): ?>
                        <p><?php echo e($slide['description']); ?></p>
                    <?php endif; ?>
                    <?php if(isset($slide['link'])): ?>
                        <a href="<?php echo e($slide['link']); ?>" class="btn btn-primary">Voir plus</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($options['arrows'] ?? true): ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo e($id); ?>" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo e($id); ?>" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/shop/components/slider.blade.php ENDPATH**/ ?>