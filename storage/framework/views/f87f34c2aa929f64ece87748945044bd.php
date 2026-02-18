

<?php $__env->startSection('title', 'Retours'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-arrow-counterclockwise"></i> Gestion des retours</h2>
</div>

<div class="card">
    <div class="card-body">
        <?php if($returns->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Boutique</th>
                            <th>Statut</th>
                            <th>Motif</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ret): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php if($ret->order): ?>
                                        <a href="<?php echo e(route('orders.show', $ret->order)); ?>"><?php echo e($ret->order->order_number); ?></a>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($ret->shop->name ?? '—'); ?></td>
                                <td><span class="badge bg-secondary"><?php echo e($ret->status); ?></span></td>
                                <td style="max-width: 360px;">
                                    <div class="text-truncate" title="<?php echo e($ret->reason); ?>"><?php echo e($ret->reason ?? '—'); ?></div>
                                </td>
                                <td>
                                    <form method="POST" action="<?php echo e(route('logistics.returns.update', $ret)); ?>" class="d-flex gap-2">
                                        <?php echo csrf_field(); ?>
                                        <select name="status" class="form-select form-select-sm" style="max-width: 150px;">
                                            <option value="in_progress" <?php if($ret->status === 'in_progress'): echo 'selected'; endif; ?>>En cours</option>
                                            <option value="accepted" <?php if($ret->status === 'accepted'): echo 'selected'; endif; ?>>Accepté</option>
                                            <option value="refused" <?php if($ret->status === 'refused'): echo 'selected'; endif; ?>>Refusé</option>
                                        </select>
                                        <input type="text" name="reason" class="form-control form-control-sm" placeholder="Motif" value="<?php echo e($ret->reason); ?>">
                                        <button class="btn btn-sm btn-outline-primary" type="submit">
                                            <i class="bi bi-check2"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <?php echo e($returns->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-arrow-counterclockwise" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun retour pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\logistics\returns.blade.php ENDPATH**/ ?>