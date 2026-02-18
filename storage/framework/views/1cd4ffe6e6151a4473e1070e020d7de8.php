

<?php $__env->startSection('title', 'Commandes'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-cart-check"></i> Toutes les commandes</h2>
    <a href="<?php echo e(route('orders.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouvelle commande
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('orders.index')); ?>" class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label">Statut</label>
                <select name="status" class="form-select">
                    <option value="">Tous</option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status); ?>" <?php if(($filters['status'] ?? '') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date (de)</label>
                <input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Date (à)</label>
                <input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Client</label>
                <input type="text" name="client" value="<?php echo e($filters['client'] ?? ''); ?>" class="form-control" placeholder="Nom, email, téléphone">
            </div>
            <div class="col-md-2">
                <label class="form-label">N° commande</label>
                <input type="text" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" class="form-control" placeholder="ORD-...">
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if($orders->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Boutique</th>
                            <th>Client</th>
                            <th>Statut</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><strong><?php echo e($order->order_number); ?></strong></td>
                                <td><?php echo e($order->shop->name ?? '—'); ?></td>
                                <td>
                                    <?php echo e($order->customer_name ?? '—'); ?>

                                    <?php if($order->customer_phone): ?>
                                        <br><small class="text-muted"><?php echo e($order->customer_phone); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?php echo e(ucfirst($order->status)); ?></span>
                                </td>
                                <td><?php echo e(number_format($order->total ?? 0, 2, ',', ' ')); ?> TND</td>
                                <td><?php echo e($order->created_at?->format('d/m/Y H:i')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
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
                <i class="bi bi-cart-check" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucune commande pour le moment.</p>
                <a href="<?php echo e(route('orders.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Créer une commande
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\orders\index.blade.php ENDPATH**/ ?>