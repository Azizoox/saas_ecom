

<?php $__env->startSection('title', 'Ramassage'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-arrow-in-down"></i> Commandes à ramasser</h2>
    <a href="<?php echo e(route('logistics.pickups.slip')); ?>" class="btn btn-outline-primary" target="_blank">
        <i class="bi bi-file-earmark-text"></i> Bon de ramassage
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if($orders->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Boutique</th>
                            <th>Client</th>
                            <th>Statut ramassage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><a href="<?php echo e(route('orders.show', $order)); ?>"><?php echo e($order->order_number); ?></a></td>
                                <td><?php echo e($order->shop->name ?? '—'); ?></td>
                                <td><?php echo e($order->customer_name ?? '—'); ?></td>
                                <td>
                                    <span class="badge bg-warning text-dark"><?php echo e($order->pickup?->status ?? 'pending'); ?></span>
                                </td>
                                <td class="text-end">
                                    <form method="POST" action="<?php echo e(route('logistics.pickups.picked', $order)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-sm btn-success" type="submit">
                                            <i class="bi bi-check2"></i> Marquer ramassé
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <?php echo e($orders->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-box-arrow-in-down" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucune commande à ramasser.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\logistics\pickups.blade.php ENDPATH**/ ?>