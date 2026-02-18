

<?php $__env->startSection('title', 'Statistiques'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-graph-up"></i> Statistiques des ventes</h2>
    <form method="GET" action="<?php echo e(route('stats.sales')); ?>" class="d-flex gap-2">
        <select name="period" class="form-select">
            <option value="day" <?php if($period === 'day'): echo 'selected'; endif; ?>>Jour</option>
            <option value="month" <?php if($period === 'month'): echo 'selected'; endif; ?>>Mois</option>
        </select>
        <button class="btn btn-outline-primary" type="submit">
            <i class="bi bi-arrow-repeat"></i>
        </button>
    </form>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total des ventes</h5>
                <h2><?php echo e(number_format($totalSales, 2, ',', ' ')); ?> TND</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Nombre de commandes</h5>
                <h2><?php echo e($ordersCount); ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Panier moyen</h5>
                <h2><?php echo e(number_format($avgBasket, 2, ',', ' ')); ?> TND</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>Ventes par période (<?php echo e($period); ?>)</strong>
    </div>
    <div class="card-body">
        <?php if($salesByPeriod->count()): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Période</th>
                            <th>Commandes</th>
                            <th>Total ventes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $salesByPeriod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($row->bucket); ?></td>
                                <td><?php echo e($row->orders_count); ?></td>
                                <td><?php echo e(number_format($row->total_sales, 2, ',', ' ')); ?> TND</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted mb-0">Aucune donnée.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\stats\sales.blade.php ENDPATH**/ ?>