<div class="scrolling-banner py-2 mb-5" style="background-color: <?php echo e($content['bg_color'] ?? '#000'); ?>; color: #fff; overflow: hidden; white-space: nowrap;">
    <div class="d-inline-block animate-scroll" style="animation: scroll <?php echo e($content['speed'] ?? 10); ?>s linear infinite;">
        <span class="px-4 fw-bold"><?php echo e($content['text_main'] ?? ''); ?></span>
        <span class="px-4 text-light opacity-75"><?php echo e($content['text_secondary'] ?? ''); ?></span>
        <span class="px-4 fw-bold"><?php echo e($content['text_main'] ?? ''); ?></span>
        <span class="px-4 text-light opacity-75"><?php echo e($content['text_secondary'] ?? ''); ?></span>
        <span class="px-4 fw-bold"><?php echo e($content['text_main'] ?? ''); ?></span>
        <span class="px-4 text-light opacity-75"><?php echo e($content['text_secondary'] ?? ''); ?></span>
    </div>
</div>

<style>
@keyframes scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.animate-scroll {
    display: inline-block;
    padding-left: 100%;
}
</style>
<?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\shop\components\banner.blade.php ENDPATH**/ ?>