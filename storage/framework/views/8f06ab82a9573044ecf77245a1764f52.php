

<?php $__env->startSection('title', 'Commandes POS'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-list-check me-2"></i>Commandes POS
        </h2>
        <a href="<?php echo e(route('pos.index')); ?>" class="btn btn-primary">
            <i class="bi bi-cart-plus me-2"></i>Nouvelle Commande
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>N° Commande</th>
                            <th>Date</th>
                            <th>Agent</th>
                            <th>Caisse</th>
                            <th>Paiement</th>
                            <th>Articles</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($order->formatted_order_number); ?></strong>
                                </td>
                                <td>
                                    <?php echo e($order->created_at->format('d/m/Y H:i')); ?>

                                </td>
                                <td>
                                    <?php echo e($order->user->getFullNameAttribute()); ?>

                                </td>
                                <td>
                                    <?php if($order->cashRegisterSession && $order->cashRegisterSession->cashRegister): ?>
                                        <?php echo e($order->cashRegisterSession->cashRegister->name); ?>

                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($order->payment_method_label); ?></span>
                                </td>
                                <td>
                                    <?php echo e($order->orderItems->count()); ?>

                                </td>
                                <td>
                                    <strong><?php echo e(number_format($order->total_amount, 3, '.', ' ')); ?> TND</strong>
                                </td>
                                <td>
                                    <span class="badge 
                                        <?php if($order->status === 'completed'): ?> bg-success 
                                        <?php elseif($order->status === 'pending'): ?> bg-warning 
                                        <?php else: ?> bg-secondary <?php endif; ?>">
                                        <?php echo e($order->status_label); ?>

                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#orderDetailsModal<?php echo e($order->id); ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="bi bi-cart-x" style="font-size: 3rem; color: #6c757d;"></i>
                                    <h4 class="mt-3">Aucune commande</h4>
                                    <p class="text-muted">Les commandes POS apparaîtront ici</p>
                                    <a href="<?php echo e(route('pos.index')); ?>" class="btn btn-primary">
                                        <i class="bi bi-cart-plus me-2"></i>Créer une commande
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($orders->hasPages()): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($orders->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Order Details Modals -->
<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="orderDetailsModal<?php echo e($order->id); ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails Commande - <?php echo e($order->formatted_order_number); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations Client</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Agent:</strong></td>
                                <td><?php echo e($order->user->getFullNameAttribute()); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Date:</strong></td>
                                <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Statut:</strong></td>
                                <td><span class="badge 
                                    <?php if($order->status === 'completed'): ?> bg-success 
                                    <?php elseif($order->status === 'pending'): ?> bg-warning 
                                    <?php else: ?> bg-secondary <?php endif; ?>">
                                    <?php echo e($order->status_label); ?>

                                </span></td>
                            </tr>
                            <tr>
                                <td><strong>Paiement:</strong></td>
                                <td><span class="badge bg-info"><?php echo e($order->payment_method_label); ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Informations Caisse</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Caisse:</strong></td>
                                <td>
                                    <?php if($order->cashRegisterSession && $order->cashRegisterSession->cashRegister): ?>
                                        <?php echo e($order->cashRegisterSession->cashRegister->name); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if($order->cashRegisterSession && $order->cashRegisterSession->cashRegister->location): ?>
                            <tr>
                                <td><strong>Emplacement:</strong></td>
                                <td><?php echo e($order->cashRegisterSession->cashRegister->location); ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>

                <h6 class="mt-4">Articles</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Qté</th>
                                <th>Prix Unitaire</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->product_name); ?></td>
                                    <td><?php echo e($item->quantity); ?></td>
                                    <td><?php echo e(number_format($item->unit_price, 3, '.', ' ')); ?> TND</td>
                                    <td><?php echo e(number_format($item->line_total, 3, '.', ' ')); ?> TND</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6 offset-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td>Sous-total:</td>
                                <td class="text-end"><?php echo e(number_format($order->subtotal, 3, '.', ' ')); ?> TND</td>
                            </tr>
                            <tr>
                                <td>TVA:</td>
                                <td class="text-end"><?php echo e(number_format($order->tax_amount, 3, '.', ' ')); ?> TND</td>
                            </tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td class="text-end"><strong><?php echo e(number_format($order->total_amount, 3, '.', ' ')); ?> TND</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Imprimer</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/pos/orders.blade.php ENDPATH**/ ?>