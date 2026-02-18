

<?php $__env->startSection('title', 'Facture'); ?>

<?php $__env->startSection('content'); ?>
<div class="alert alert-warning">
    Aucune facture n’a été générée pour la commande <strong><?php echo e($order->order_number); ?></strong>.
</div>

<form method="POST" action="<?php echo e(route('invoices.generate', $order)); ?>">
    <?php echo csrf_field(); ?>
    <button class="btn btn-primary" type="submit">
        <i class="bi bi-receipt"></i> Générer la facture
    </button>
</form>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\invoices\missing.blade.php ENDPATH**/ ?>