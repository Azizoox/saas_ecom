

<?php $__env->startSection('title', 'Mes commandes - ' . $shop->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Mes commandes</h4>
                </div>
                <div class="card-body">
                    <?php if($orders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th># Commande</th>
                                        <th>Boutique</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($order->order_number); ?></td>
                                            <td><?php echo e($order->shop->name ?? 'N/A'); ?></td>
                                            <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e($order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning')); ?>">
                                                    <?php echo e(ucfirst($order->status)); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e(number_format($order->total, 2, ',', ' ')); ?> TND</td>
                                            <td>
                                                <a href="<?php echo e(route('shop.orders.show', ['subdomain' => $shop->subdomain, 'id' => $order->id])); ?>" class="btn btn-sm btn-primary">
                                                    Voir
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <?php echo e($orders->links()); ?>

                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x fs-1 text-muted"></i>
                            <h5 class="mt-3">Aucune commande trouvée</h5>
                            <p class="text-muted">Vous n'avez pas encore passé de commande sur cette boutique.</p>
                            <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain])); ?>" class="btn btn-primary">
                                <i class="bi bi-shop me-1"></i> Aller à la boutique
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shop.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/shop/mescommandes.blade.php ENDPATH**/ ?>