

<?php $__env->startSection('title', 'Bon de ramassage'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-file-earmark-text"></i> Bon de ramassage</h2>
    <a href="#" class="btn btn-outline-secondary" onclick="window.print(); return false;">
        <i class="bi bi-printer"></i> Imprimer
    </a>
</div>

<div class="card">
    <div class="card-body">
        <p class="text-muted mb-3">Généré le <?php echo e(now()->format('d/m/Y H:i')); ?></p>

        <?php if($orders->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Boutique</th>
                            <th>Commande</th>
                            <th>Client</th>
                            <th>Adresse</th>
                            <th>Signature</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($order->shop->name ?? '—'); ?></td>
                                <td><?php echo e($order->order_number); ?></td>
                                <td><?php echo e($order->customer_name ?? '—'); ?></td>
                                <td style="min-width: 260px;">
                                    <?php echo e($order->shipping_address); ?><br>
                                    <?php echo e($order->shipping_city); ?> <?php echo e($order->shipping_postal_code); ?><br>
                                    <?php echo e($order->shipping_country); ?>

                                </td>
                                <td style="width: 200px;"></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">Aucune commande en attente.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\logistics\pickup_slip.blade.php ENDPATH**/ ?>