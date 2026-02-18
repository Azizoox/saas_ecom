<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Card -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">👋 Bonjour, <?php echo e(explode(' ', $user->full_name)[0] ?? $user->email); ?>!</h2>
                        <p class="text-muted mb-0">Bienvenue dans votre espace de gestion Shoopino</p>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-shop text-primary" style="font-size: 2rem;"></i>
                        </div>
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
                        <h6 class="text-muted mb-1">Boutiques</h6>
                        <h2 class="mb-0 text-primary"><?php echo e($shops->count()); ?></h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-shop text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-success">
                        <i class="bi bi-arrow-up-circle"></i> <?php echo e($shops->where('status', 'active')->count()); ?> actives
                    </small>
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
                        <h2 class="mb-0 text-success"><?php echo e($totalProducts ?? 0); ?></h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-box-seam text-success" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> Total dans toutes les boutiques
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Catégories</h6>
                        <h2 class="mb-0 text-info"><?php echo e($totalCategories ?? 0); ?></h2>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-tags text-info" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bi bi-collection"></i> Organisez vos produits
                    </small>
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
                        <h2 class="mb-0 text-warning"><?php echo e($totalOrders ?? 0); ?></h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-cart-check text-warning" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bi bi-graph-up"></i> En attente de traitement
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="bi bi-lightning-fill text-primary me-2"></i>
                    Actions rapides
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('products.create')); ?>" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-plus-circle d-block mb-2" style="font-size: 1.5rem;"></i>
                            <span>Ajouter un produit</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-outline-success w-100 py-3">
                            <i class="bi bi-tags d-block mb-2" style="font-size: 1.5rem;"></i>
                            <span>Nouvelle catégorie</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('builder.index')); ?>" class="btn btn-outline-info w-100 py-3">
                            <i class="bi bi-layout-text-sidebar-reverse d-block mb-2" style="font-size: 1.5rem;"></i>
                            <span>Builder page</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="<?php echo e(route('settings.index')); ?>" class="btn btn-outline-secondary w-100 py-3">
                            <i class="bi bi-gear d-block mb-2" style="font-size: 1.5rem;"></i>
                            <span>Paramètres</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shops Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-shop-window me-2 text-primary"></i>
                        Mes boutiques
                    </h5>
                    <a href="#" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus"></i> Nouvelle boutique
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if($shops->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Sous-domaine</th>
                                    <th>Statut</th>
                                    <th>Produits</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                                <i class="bi bi-shop text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?php echo e($shop->name); ?></h6>
                                                <small class="text-muted">Créée le <?php echo e($shop->created_at->format('d/m/Y')); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain])); ?>" 
                                           target="_blank" 
                                           class="text-decoration-none">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>
                                            <?php echo e($shop->subdomain); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo e($shop->status === 'active' ? 'success' : 'secondary'); ?>">
                                            <?php echo e(ucfirst($shop->status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">
                                            <?php echo e($shop->products()->count()); ?> produits
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain])); ?>" 
                                               target="_blank" 
                                               class="btn btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-secondary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-shop text-muted" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Aucune boutique trouvée</h4>
                        <p class="text-muted">Commencez par créer votre première boutique en ligne.</p>
                        <a href="#" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Créer une boutique
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\dashboard\index.blade.php ENDPATH**/ ?>