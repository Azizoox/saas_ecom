

<?php $__env->startSection('title', 'Étiquette'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-tag"></i> Étiquette colis</h2>
    <a href="#" class="btn btn-outline-secondary" onclick="window.print(); return false;">
        <i class="bi bi-printer"></i> Imprimer
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Expéditeur</h5>
                <div><strong><?php echo e($order->shop->company_name ?: $order->shop->name); ?></strong></div>
                <div class="text-muted"><?php echo e($order->shop->street); ?></div>
                <div class="text-muted"><?php echo e($order->shop->city); ?> <?php echo e($order->shop->postal_code); ?></div>
                <div class="text-muted"><?php echo e($order->shop->contact_phone); ?></div>
            </div>
            <div class="col-md-6">
                <h5>Destinataire</h5>
                <div><strong><?php echo e($order->customer_name ?? '—'); ?></strong></div>
                <div class="text-muted"><?php echo e($order->customer_phone ?? ''); ?></div>
                <div class="text-muted mt-2">
                    <?php echo e($order->shipping_address); ?><br>
                    <?php echo e($order->shipping_city); ?> <?php echo e($order->shipping_postal_code); ?><br>
                    <?php echo e($order->shipping_country); ?>

                </div>
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-between">
            <div>
                <div class="text-muted">Commande</div>
                <div style="font-size: 24px;"><strong><?php echo e($order->order_number); ?></strong></div>
            </div>
            <div class="text-end">
                <div class="text-muted">Statut emballage</div>
                <div><span class="badge bg-secondary"><?php echo e($order->packing?->status ?? 'pending'); ?></span></div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/logistics/label.blade.php ENDPATH**/ ?>