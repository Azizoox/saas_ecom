

<?php $__env->startSection('title', 'Historique Caisse'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-journal-text me-2"></i>Historique Caisse
        </h2>
        <div>
            <a href="<?php echo e(route('pos.index')); ?>" class="btn btn-primary">
                <i class="bi bi-cart me-2"></i>POS
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Espèces</h6>
                            <h3 class="mb-0"><?php echo e(number_format($totalCashSales, 2, ',', ' ')); ?> TND</h3>
                        </div>
                        <i class="bi bi-cash fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Carte</h6>
                            <h3 class="mb-0"><?php echo e(number_format($totalCardSales, 2, ',', ' ')); ?> TND</h3>
                        </div>
                        <i class="bi bi-credit-card fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Ventes</h6>
                            <h3 class="mb-0"><?php echo e(number_format($totalSales, 2, ',', ' ')); ?> TND</h3>
                        </div>
                        <i class="bi bi-graph-up fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card <?php if($totalDifference > 0): ?> bg-warning <?php elseif($totalDifference < 0): ?> bg-danger <?php else: ?> bg-secondary <?php endif; ?> text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Écart Total</h6>
                            <h3 class="mb-0"><?php echo e(number_format(abs($totalDifference), 2, ',', ' ')); ?> TND</h3>
                        </div>
                        <i class="bi bi-exclamation-triangle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-list me-2"></i>Sessions de Caisse
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Caisse</th>
                            <th>Agent</th>
                            <th>Ouverture</th>
                            <th>Fermeture</th>
                            <th>Fond Initial</th>
                            <th>Ventes Espèces</th>
                            <th>Ventes Carte</th>
                            <th>Total Ventes</th>
                            <th>Attendu</th>
                            <th>Réel</th>
                            <th>Écart</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($session->cashRegister->name); ?></strong>
                                    <?php if($session->cashRegister->location): ?>
                                        <div class="small text-muted"><?php echo e($session->cashRegister->location); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e($session->user->getFullNameAttribute()); ?>

                                </td>
                                <td>
                                    <?php echo e($session->opened_at ? $session->opened_at->format('d/m/Y H:i') : '-'); ?>

                                </td>
                                <td>
                                    <?php echo e($session->closed_at ? $session->closed_at->format('d/m/Y H:i') : '-'); ?>

                                </td>
                                <td>
                                    <?php echo e(number_format($session->opening_amount, 2, ',', ' ')); ?> TND
                                </td>
                                <td class="text-success">
                                    <?php echo e(number_format($session->cash_sales, 2, ',', ' ')); ?> TND
                                </td>
                                <td class="text-primary">
                                    <?php echo e(number_format($session->card_sales, 2, ',', ' ')); ?> TND
                                </td>
                                <td>
                                    <strong><?php echo e(number_format($session->total_sales, 2, ',', ' ')); ?> TND</strong>
                                </td>
                                <td>
                                    <?php echo e(number_format($session->expected_amount, 2, ',', ' ')); ?> TND
                                </td>
                                <td>
                                    <?php echo e($session->actual_amount ? number_format($session->actual_amount, 2, ',', ' ') . ' TND' : '-'); ?>

                                </td>
                                <td>
                                    <?php if($session->difference > 0): ?>
                                        <span class="badge bg-warning">+<?php echo e(number_format($session->difference, 2, ',', ' ')); ?> TND</span>
                                    <?php elseif($session->difference < 0): ?>
                                        <span class="badge bg-danger"><?php echo e(number_format($session->difference, 2, ',', ' ')); ?> TND</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">0.00 TND</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($session->status === 'open'): ?>
                                        <span class="badge bg-success">Ouverte</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Fermée</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#sessionDetailsModal<?php echo e($session->id); ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="13" class="text-center py-5">
                                    <i class="bi bi-journal-x" style="font-size: 3rem; color: #6c757d;"></i>
                                    <h4 class="mt-3">Aucune session</h4>
                                    <p class="text-muted">Les sessions de caisse apparaîtront ici</p>
                                    <a href="<?php echo e(route('pos.index')); ?>" class="btn btn-primary">
                                        <i class="bi bi-cash-coin me-2"></i>Ouvrir une caisse
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($sessions->hasPages()): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($sessions->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Session Details Modals -->
<?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="sessionDetailsModal<?php echo e($session->id); ?>" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails Session - <?php echo e($session->cashRegister->name); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Informations de Session</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Caisse:</strong></td>
                                <td><?php echo e($session->cashRegister->name); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Emplacement:</strong></td>
                                <td><?php echo e($session->cashRegister->location ?? 'Non spécifié'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Agent:</strong></td>
                                <td><?php echo e($session->user->getFullNameAttribute()); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Statut:</strong></td>
                                <td>
                                    <?php if($session->status === 'open'): ?>
                                        <span class="badge bg-success">Ouverte</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Fermée</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Ouverte le:</strong></td>
                                <td><?php echo e($session->opened_at ? $session->opened_at->format('d/m/Y H:i:s') : '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Fermée le:</strong></td>
                                <td><?php echo e($session->closed_at ? $session->closed_at->format('d/m/Y H:i:s') : '-'); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Résumé Financier</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Fond initial:</strong></td>
                                <td><?php echo e(number_format($session->opening_amount, 2, ',', ' ')); ?> TND</td>
                            </tr>
                            <tr>
                                <td><strong>Ventes espèces:</strong></td>
                                <td class="text-success">+<?php echo e(number_format($session->cash_sales, 2, ',', ' ')); ?> TND</td>
                            </tr>
                            <tr>
                                <td><strong>Ventes carte:</strong></td>
                                <td class="text-primary">+<?php echo e(number_format($session->card_sales, 2, ',', ' ')); ?> TND</td>
                            </tr>
                            <tr>
                                <td><strong>Total ventes:</strong></td>
                                <td><?php echo e(number_format($session->total_sales, 2, ',', ' ')); ?> TND</td>
                            </tr>
                            <tr>
                                <td><strong>Attendu en caisse:</strong></td>
                                <td class="text-warning"><?php echo e(number_format($session->expected_amount, 2, ',', ' ')); ?> TND</td>
                            </tr>
                            <tr>
                                <td><strong>Montant réel:</strong></td>
                                <td><?php echo e($session->actual_amount ? number_format($session->actual_amount, 2, ',', ' ') . ' TND' : '-'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Écart:</strong></td>
                                <td>
                                    <?php if($session->difference > 0): ?>
                                        <span class="text-warning">+<?php echo e(number_format($session->difference, 2, ',', ' ')); ?> TND</span>
                                    <?php elseif($session->difference < 0): ?>
                                        <span class="text-danger"><?php echo e(number_format($session->difference, 2, ',', ' ')); ?> TND</span>
                                    <?php else: ?>
                                        <span class="text-success">0.00 TND</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <?php if($session->notes): ?>
                <div class="mb-4">
                    <h6>Notes</h6>
                    <div class="alert alert-info">
                        <?php echo e($session->notes); ?>

                    </div>
                </div>
                <?php endif; ?>

                <h6>Commandes de la Session</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>N° Commande</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Paiement</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $session->posOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($order->order_number); ?></td>
                                    <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                                    <td><?php echo e($order->customer_name ?? 'Client anonyme'); ?></td>
                                    <td>
                                        <?php if($order->payment_method === 'cash'): ?>
                                            <span class="badge bg-success">Espèces</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary">Carte</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(number_format($order->total, 2, ',', ' ')); ?> TND</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Aucune commande</td>
                                </tr>
                            <?php endif; ?>
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
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\pos\history.blade.php ENDPATH**/ ?>