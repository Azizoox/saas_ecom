<div class="marquee-container my-4 py-2" style="background-color: <?php echo e($bg_color); ?>; color: <?php echo e($text_color); ?>; overflow: hidden; white-space: nowrap;">
    <div class="marquee-content d-inline-block" style="animation: marquee-<?php echo e($speed); ?> <?php echo e($speed === 'slow' ? '30s' : ($speed === 'fast' ? '10s' : '20s')); ?> linear infinite;">
        <span class="px-4 fw-bold text-uppercase"><?php echo e($text); ?></span>
        <span class="px-4 fw-bold text-uppercase"><?php echo e($text); ?></span>
        <span class="px-4 fw-bold text-uppercase"><?php echo e($text); ?></span>
        <span class="px-4 fw-bold text-uppercase"><?php echo e($text); ?></span>
    </div>
</div>

<style>
    @keyframes marquee-<?php echo e($speed); ?> {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .marquee-content {
        display: inline-block;
        padding-left: 100%;
        animation: marquee-<?php echo e($speed); ?> 20s linear infinite;
    }
    .marquee-container:hover .marquee-content {
        animation-play-state: paused;
    }
</style>
<?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\shop\components\marquee.blade.php ENDPATH**/ ?>