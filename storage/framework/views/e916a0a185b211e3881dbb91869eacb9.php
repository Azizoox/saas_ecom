

<?php $__env->startSection('title', 'Détails Utilisateur - ' . $user->full_name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold;">
                                <?php echo e(strtoupper(substr($user->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($user->last_name, 0, 1))); ?>

                            </div>
                            <div>
                                <h2 class="mb-1"><?php echo e($user->full_name); ?></h2>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-envelope"></i> <?php echo e($user->email); ?>

                                    <?php if($user->phone): ?>
                                        | <i class="bi bi-telephone"></i> <?php echo e($user->phone); ?>

                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="mb-2">
                                <?php if($user->role === 'super_admin'): ?>
                                    <span class="badge bg-danger fs-6">Super Admin</span>
                                <?php elseif($user->role === 'merchant'): ?>
                                    <span class="badge bg-success fs-6">Marchand</span>
                                <?php else: ?>
                                    <span class="badge bg-info fs-6">Client</span>
                                <?php endif; ?>
                            </div>
                            <?php if($user->email_verified_at): ?>
                                <div><span class="badge bg-success"><i class="bi bi-check-circle"></i> Email vérifié</span></div>
                            <?php else: ?>
                                <div><span class="badge bg-warning"><i class="bi bi-clock"></i> Email non vérifié</span></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informations utilisateur -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">📋 Informations Personnelles</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Prénom</label>
                                <p class="fw-bold"><?php echo e($user->first_name); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Nom</label>
                                <p class="fw-bold"><?php echo e($user->last_name); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <p class="fw-bold"><?php echo e($user->email); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Téléphone</label>
                                <p class="fw-bold"><?php echo e($user->phone ?? 'Non fourni'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-0">
                                <label class="form-label text-muted">Date d'inscription</label>
                                <p class="fw-bold"><?php echo e($user->created_at->format('d/m/Y à H:i')); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-0">
                                <label class="form-label text-muted">Dernière mise à jour</label>
                                <p class="fw-bold"><?php echo e($user->updated_at->format('d/m/Y à H:i')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0">📊 Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted">Boutiques</span>
                            <span class="badge bg-primary"><?php echo e($userStats['shops_count']); ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted">Produits</span>
                            <span class="badge bg-success"><?php echo e($userStats['total_products']); ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted">Commandes</span>
                            <span class="badge bg-warning"><?php echo e($userStats['total_orders']); ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted">Commandes en attente</span>
                            <span class="badge bg-danger"><?php echo e($userStats['pending_orders']); ?></span>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted fw-bold">Revenu Total</span>
                            <span class="badge bg-info fs-6"><?php echo e(number_format($userStats['total_revenue'], 2)); ?> $</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Boutiques de l'utilisateur -->
    <?php if($user->shops->count() > 0): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">🏪 Boutiques (<?php echo e($user->shops->count()); ?>)</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom de la boutique</th>
                                    <th>Sous-domaine</th>
                                    <th>Statut</th>
                                    <th>Date de création</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $user->shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><strong><?php echo e($shop->name); ?></strong></td>
                                        <td><code><?php echo e($shop->subdomain); ?></code></td>
                                        <td>
                                            <?php if($shop->status === 'active'): ?>
                                                <span class="badge bg-success">Actif</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Inactif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($shop->created_at->format('d/m/Y')); ?></td>
                                        <td class="text-end">
                                            <a href="<?php echo e(route('shop.index', $shop->subdomain)); ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="bi bi-arrow-up-right"></i> Visiter
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">⚙️ Actions</h5>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('super-admin.users.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Retour à la liste
                        </a>
                        <?php if($user->id !== auth()->id()): ?>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bi bi-trash"></i> Supprimer cet utilisateur
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<?php if($user->id !== auth()->id()): ?>
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">⚠️ Confirmer la suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Êtes-vous sûr de vouloir supprimer <strong><?php echo e($user->full_name); ?></strong> ?</p>
                    <p class="text-danger small"><i class="bi bi-exclamation-triangle"></i> Cette action est irréversible et supprimera :</p>
                    <ul class="text-danger small">
                        <li>Le compte utilisateur</li>
                        <li>Tous les profils associés</li>
                        <li>Toutes les données de connexion</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form method="POST" action="<?php echo e(route('super-admin.users.destroy', $user)); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/super-admin/users/show.blade.php ENDPATH**/ ?>