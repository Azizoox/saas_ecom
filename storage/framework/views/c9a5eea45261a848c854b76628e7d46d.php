

<?php $__env->startSection('title', 'Détail commande'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0"><i class="bi bi-receipt"></i> <?php echo e($order->order_number); ?></h2>
        <small class="text-muted">Créée le <?php echo e($order->created_at?->format('d/m/Y H:i')); ?> — Boutique: <?php echo e($order->shop->name ?? '—'); ?></small>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Produits</strong>
                <span class="badge bg-secondary"><?php echo e(ucfirst($order->status)); ?></span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Qté</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($item->product_name); ?></strong>
                                        <?php if($item->sku): ?>
                                            <br><small class="text-muted">SKU: <?php echo e($item->sku); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(number_format($item->unit_price, 2, ',', ' ')); ?> TND</td>
                                    <td><?php echo e($item->quantity); ?></td>
                                    <td><?php echo e(number_format($item->line_total, 2, ',', ' ')); ?> TND</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    <div style="min-width: 250px;">
                        <div class="d-flex justify-content-between">
                            <span>Sous-total</span>
                            <strong><?php echo e(number_format($order->subtotal ?? 0, 2, ',', ' ')); ?> TND</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Livraison</span>
                            <strong><?php echo e(number_format($order->shipping_total ?? 0, 2, ',', ' ')); ?> TND</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Remise</span>
                            <strong>-<?php echo e(number_format($order->discount_total ?? 0, 2, ',', ' ')); ?> TND</strong>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span>Total</span>
                            <strong><?php echo e(number_format($order->total ?? 0, 2, ',', ' ')); ?> TND</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <strong>Historique des statuts</strong>
            </div>
            <div class="card-body">
                <?php if($order->statusHistories->count()): ?>
                    <ul class="list-group">
                        <?php $__currentLoopData = $order->statusHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <div>
                                        <strong><?php echo e(ucfirst($h->to_status)); ?></strong>
                                        <?php if($h->from_status): ?>
                                            <small class="text-muted">(depuis <?php echo e($h->from_status); ?>)</small>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($h->note): ?>
                                        <div class="text-muted"><?php echo e($h->note); ?></div>
                                    <?php endif; ?>
                                    <small class="text-muted">
                                        <?php echo e($h->created_at?->format('d/m/Y H:i')); ?>

                                        <?php if($h->changedBy): ?>
                                            — <?php echo e($h->changedBy->email); ?>

                                        <?php endif; ?>
                                    </small>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-0">Aucun historique.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <strong>Client</strong>
            </div>
            <div class="card-body">
                <div><strong>Nom:</strong> <?php echo e($order->customer_name ?? '—'); ?></div>
                <div><strong>Email:</strong> <?php echo e($order->customer_email ?? '—'); ?></div>
                <div><strong>Téléphone:</strong> <?php echo e($order->customer_phone ?? '—'); ?></div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <strong>Livraison</strong>
            </div>
            <div class="card-body">
                <div><strong>Adresse:</strong><br><?php echo e($order->shipping_address ?? '—'); ?></div>
                <div class="mt-2"><strong>Ville:</strong> <?php echo e($order->shipping_city ?? '—'); ?></div>
                <div><strong>Code postal:</strong> <?php echo e($order->shipping_postal_code ?? '—'); ?></div>
                <div><strong>État:</strong> <?php echo e($order->shipping_state ?? '—'); ?></div>
                <div><strong>Pays:</strong> <?php echo e($order->shipping_country ?? '—'); ?></div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <strong>Paiement</strong>
            </div>
            <div class="card-body">
                <div><strong>Méthode:</strong> <?php echo e($order->payment_method ?? '—'); ?></div>
                <div><strong>Statut:</strong> <?php echo e($order->payment_status ?? '—'); ?></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Actions</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('orders.status', $order)); ?>" class="mb-3">
                    <?php echo csrf_field(); ?>
                    <label class="form-label">Modifier statut</label>
                    <select name="status" class="form-select mb-2" required>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php if($order->status === $s): echo 'selected'; endif; ?>><?php echo e(ucfirst($s)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input type="text" name="note" class="form-control mb-2" placeholder="Note (optionnel)">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-arrow-repeat"></i> Mettre à jour
                    </button>
                </form>

                <div class="d-grid gap-2">
                    <a class="btn btn-outline-secondary" href="#" onclick="window.print(); return false;">
                        <i class="bi bi-printer"></i> Imprimer
                    </a>
                    <form method="POST" action="<?php echo e(route('invoices.generate', $order)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-outline-primary w-100" type="submit">
                            <i class="bi bi-receipt"></i> Générer facture
                        </button>
                    </form>
                    <?php if($order->invoice): ?>
                        <a class="btn btn-outline-primary" href="<?php echo e(route('invoices.show', $order)); ?>">
                            <i class="bi bi-eye"></i> Voir facture
                        </a>
                        <a class="btn btn-outline-danger" href="<?php echo e(route('invoices.pdf', $order)); ?>">
                            <i class="bi bi-file-earmark-pdf"></i> Télécharger PDF
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/orders/show.blade.php ENDPATH**/ ?>