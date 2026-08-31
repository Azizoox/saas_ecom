<?php
    $slides = $content['slides'] ?? [];
    $options = $content['options'] ?? [];
    $autoplay = $options['autoplay'] ?? true;
    $interval = $options['interval'] ?? 6000;
?>

<?php if(count($slides) > 0): ?>
<section class="hero-slider mb-5">
<div id="carousel-<?php echo e($id); ?>"
     class="carousel slide hero-slider-inner"
     data-bs-ride="<?php echo e($autoplay ? 'carousel' : 'false'); ?>"
     <?php if($autoplay): ?> data-bs-interval="<?php echo e($interval); ?>" <?php endif; ?>>
    <?php if($options['pagination'] ?? true): ?>
    <div class="carousel-indicators">
        <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button
                type="button"
                data-bs-target="#carousel-<?php echo e($id); ?>"
                data-bs-slide-to="<?php echo e($index); ?>"
                class="<?php echo e($index === 0 ? 'active' : ''); ?>"
                aria-label="Slide <?php echo e($index + 1); ?>">
            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <div class="carousel-inner">
        <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($slide['image'])): ?>
            <div class="carousel-item hero-slide <?php echo e($index === 0 ? 'active' : ''); ?>">
                <div class="hero-slide-bg"
                     style="background-image: url('<?php echo e(Storage::url($slide['image'])); ?>');">
                </div>

                <div class="hero-overlay"></div>

                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="carousel-caption hero-caption text-start">
                                <?php if(!empty($slide['eyebrow'])): ?>
                                    <div class="hero-eyebrow"><?php echo e($slide['eyebrow']); ?></div>
                                <?php endif; ?>

                                <?php if(isset($slide['title'])): ?>
                                    <h2 class="hero-title"><?php echo e($slide['title']); ?></h2>
                                <?php endif; ?>

                                <?php if(isset($slide['description'])): ?>
                                    <p class="hero-subtitle"><?php echo e($slide['description']); ?></p>
                                <?php endif; ?>

                                <?php if(isset($slide['link'])): ?>
                                    <a href="<?php echo e($slide['link']); ?>"
                                       class="btn hero-cta">
                                        <?php echo e($slide['button_label'] ?? 'Voir plus'); ?>

                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($options['arrows'] ?? true): ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo e($id); ?>" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo e($id); ?>" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
    <?php endif; ?>
</div>
</section>
<?php endif; ?>
<?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/shop/components/slider.blade.php ENDPATH**/ ?>