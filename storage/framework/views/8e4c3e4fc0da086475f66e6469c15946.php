

<?php $__env->startSection('title', 'Factures'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-receipt"></i> Historique des factures</h2>
</div>

<div class="card">
    <div class="card-body">
        <?php if($invoices->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>N° facture</th>
                            <th>Commande</th>
                            <th>Boutique</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><strong><?php echo e($invoice->invoice_number); ?></strong></td>
                                <td><?php echo e($invoice->order->order_number ?? '—'); ?></td>
                                <td><?php echo e($invoice->shop->name ?? '—'); ?></td>
                                <td><?php echo e($invoice->issued_at?->format('d/m/Y') ?? '—'); ?></td>
                                <td><?php echo e(number_format($invoice->total ?? 0, 2, ',', ' ')); ?> TND</td>
                                <td>
                                    <?php if($invoice->order): ?>
                                        <a href="<?php echo e(route('invoices.show', $invoice->order)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <?php echo e($invoices->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-receipt" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucune facture pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\invoices\index.blade.php ENDPATH**/ ?>