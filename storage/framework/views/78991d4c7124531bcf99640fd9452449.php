

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
                            <th>Client</th>
                            <th>Caisse</th>
                            <th>Paiement</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($order->order_number); ?></strong>
                                </td>
                                <td>
                                    <?php echo e($order->created_at->format('d/m/Y H:i')); ?>

                                </td>
                                <td>
                                    <?php echo e($order->customer_name ?? 'Client anonyme'); ?>

                                </td>
                                <td>
                                    <?php echo e($order->session->cashRegister->name); ?>

                                </td>
                                <td>
                                    <?php if($order->payment_method === 'cash'): ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-cash me-1"></i> Espèces
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">
                                            <i class="bi bi-credit-card me-1"></i> Carte
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo e(number_format($order->total, 2, ',', ' ')); ?> TND</strong>
                                </td>
                                <td>
                                    <span class="badge bg-success">Complétée</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderDetailsModal<?php echo e($order->id); ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
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
                <h5 class="modal-title">Détails Commande - <?php echo e($order->order_number); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Informations Générales</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>N° Commande:</strong></td>
                                <td><?php echo e($order->order_number); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Date:</strong></td>
                                <td><?php echo e($order->created_at->format('d/m/Y H:i:s')); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Client:</strong></td>
                                <td><?php echo e($order->customer_name ?? 'Client anonyme'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Caisse:</strong></td>
                                <td><?php echo e($order->session->cashRegister->name); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Agent:</strong></td>
                                <td><?php echo e($order->session->user->getFullNameAttribute()); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Détails Financiers</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Sous-total:</strong></td>
                                <td><?php echo e(number_format($order->subtotal, 2, ',', ' ')); ?> TND</td>
                            </tr>
                            <tr>
                                <td><strong>Remise:</strong></td>
                                <td class="text-danger">-<?php echo e(number_format($order->discount, 2, ',', ' ')); ?> TND</td>
                            </tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td class="text-success fw-bold"><?php echo e(number_format($order->total, 2, ',', ' ')); ?> TND</td>
                            </tr>
                            <tr>
                                <td><strong>Paiement:</strong></td>
                                <td>
                                    <?php if($order->payment_method === 'cash'): ?>
                                        <span class="badge bg-success">Espèces</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Carte</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <h6>Articles</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->product_name); ?></td>
                                    <td><?php echo e($item->quantity); ?></td>
                                    <td><?php echo e(number_format($item->unit_price, 2, ',', ' ')); ?> TND</td>
                                    <td><?php echo e(number_format($item->line_total, 2, ',', ' ')); ?> TND</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="bi bi-printer me-2"></i>Imprimer
                </button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\pos\orders.blade.php ENDPATH**/ ?>