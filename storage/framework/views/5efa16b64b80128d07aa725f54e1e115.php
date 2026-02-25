

<?php $__env->startSection('title', 'Emballage'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box2"></i> Colis à emballer</h2>
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
                            <th>Statut emballage</th>
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
                                    <span class="badge bg-warning text-dark"><?php echo e($order->packing?->status ?? 'pending'); ?></span>
                                </td>
                                <td class="text-end d-flex justify-content-end gap-2">
                                    <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('logistics.packings.label', $order)); ?>" target="_blank">
                                        <i class="bi bi-tag"></i> Étiquette
                                    </a>
                                    <form method="POST" action="<?php echo e(route('logistics.packings.packed', $order)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-sm btn-success" type="submit">
                                            <i class="bi bi-check2"></i> Valider
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
                <i class="bi bi-box2" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun colis à emballer.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/logistics/packings.blade.php ENDPATH**/ ?>