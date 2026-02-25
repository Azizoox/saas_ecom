<?php $__env->startSection('title', 'Super Admin - Tableau de bord'); ?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Card -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">🔐 Super Admin - <?php echo e($user->email); ?></h2>
                        <p class="text-muted mb-0">Vue d'ensemble de la plateforme Shoopino</p>
                    </div>
                    <div class="d-none d-md-block">
                        <span class="badge bg-danger fs-6">Super Admin</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Utilisateurs</h6>
                        <h2 class="mb-0 text-primary"><?php echo e($stats['users_count']); ?></h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-people text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Boutiques</h6>
                        <h2 class="mb-0 text-success"><?php echo e($stats['shops_count']); ?></h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-shop text-success" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-muted"><?php echo e($stats['shops_active']); ?> actives</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Produits</h6>
                        <h2 class="mb-0 text-info"><?php echo e($stats['products_count']); ?></h2>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-box-seam text-info" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Commandes</h6>
                        <h2 class="mb-0 text-warning"><?php echo e($stats['orders_count']); ?></h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-cart-check text-warning" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-muted"><?php echo e($stats['orders_pending']); ?> en attente</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chiffre d'affaires total -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="opacity-90 mb-1">Chiffre d'affaires total (hors annulées)</h6>
                        <h2 class="mb-0"><?php echo e(number_format($stats['orders_total_amount'], 2, ',', ' ')); ?> TND</h2>
                    </div>
                    <i class="bi bi-currency-exchange" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Derniers utilisateurs -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-people me-2 text-primary"></i>Derniers utilisateurs</h5>
            </div>
            <div class="card-body p-0">
                <?php if($recentUsers->count() > 0): ?>
                    <ul class="list-group list-group-flush">
                        <?php $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo e($u->full_name); ?></strong>
                                    <br><small class="text-muted"><?php echo e($u->email); ?></small>
                                </div>
                                <span class="badge bg-secondary"><?php echo e($u->role); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted p-3 mb-0">Aucun utilisateur.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Dernières boutiques -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-shop me-2 text-success"></i>Dernières boutiques</h5>
            </div>
            <div class="card-body p-0">
                <?php if($recentShops->count() > 0): ?>
                    <ul class="list-group list-group-flush">
                        <?php $__currentLoopData = $recentShops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo e($s->name); ?></strong>
                                    <br><small class="text-muted"><?php echo e($s->subdomain); ?></small>
                                </div>
                                <span class="badge bg-<?php echo e($s->status === 'active' ? 'success' : 'secondary'); ?>"><?php echo e($s->status); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted p-3 mb-0">Aucune boutique.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Dernières commandes -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-cart-check me-2 text-warning"></i>Dernières commandes</h5>
            </div>
            <div class="card-body p-0">
                <?php if($recentOrders->count() > 0): ?>
                    <ul class="list-group list-group-flush">
                        <?php $__currentLoopData = $recentOrders->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo e($o->order_number); ?></strong>
                                    <br><small class="text-muted"><?php echo e($o->shop->name ?? '-'); ?> · <?php echo e(number_format($o->total, 0, ',', ' ')); ?> TND</small>
                                </div>
                                <span class="badge bg-<?php echo e($o->status === 'new' ? 'warning' : ($o->status === 'delivered' ? 'success' : 'info')); ?>"><?php echo e($o->status); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted p-3 mb-0">Aucune commande.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/super-admin/dashboard.blade.php ENDPATH**/ ?>