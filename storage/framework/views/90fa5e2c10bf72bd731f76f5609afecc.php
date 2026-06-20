

<?php $__env->startSection('title', 'Gestion des Utilisateurs -  Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1">👥 Gestion des Utilisateurs</h2>
                            <p class="text-muted mb-0">Consulter, filtrer et gérer les utilisateurs de la plateforme</p>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-primary fs-6">Total: <?php echo e($roleStats['total']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques par rôle -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Utilisateurs</h6>
                            <h3 class="mb-0 text-primary"><?php echo e($roleStats['total']); ?></h3>
                        </div>
                        <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Super Admins</h6>
                            <h3 class="mb-0 text-danger"><?php echo e($roleStats['super_admin']); ?></h3>
                        </div>
                        <i class="bi bi-shield-lock text-danger" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Marchands</h6>
                            <h3 class="mb-0 text-success"><?php echo e($roleStats['merchant']); ?></h3>
                        </div>
                        <i class="bi bi-shop text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Clients</h6>
                            <h3 class="mb-0 text-info"><?php echo e($roleStats['customer']); ?></h3>
                        </div>
                        <i class="bi bi-person-check text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('super-admin.users.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher (nom, email, téléphone)..." value="<?php echo e($search); ?>">
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">Tous les rôles</option>
                        <option value="super_admin" <?php echo e($role === 'super_admin' ? 'selected' : ''); ?>>Super Admin</option>
                        <option value="merchant" <?php echo e($role === 'merchant' ? 'selected' : ''); ?>>Marchand</option>
                        <option value="customer" <?php echo e($role === 'customer' ? 'selected' : ''); ?>>Client</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Chercher
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="<?php echo e(route('super-admin.users.index')); ?>" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-clockwise"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table des utilisateurs -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Rôle</th>
                        <th>Date d'inscription</th>
                        <th>Statut Email</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                        <?php echo e(strtoupper(substr($user->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($user->last_name, 0, 1))); ?>

                                    </div>
                                    <div>
                                        <h6 class="mb-0"><strong><?php echo e($user->full_name); ?></strong></h6>
                                        <small class="text-muted">ID: <?php echo e($user->id); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo e($user->email); ?></td>
                            <td><?php echo e($user->phone ?? 'N/A'); ?></td>
                            <td>
                                
                                <?php if($user->role === 'owner'): ?>
                                    <span class="badge bg-success">Marchand</span>
                                <?php elseif($user->role === 'client'): ?>
                                    <span class="badge bg-info">Client</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <small><?php echo e($user->created_at->format('d/m/Y H:i')); ?></small>
                            </td>
                            <td>
                                <?php if($user->email_verified_at): ?>
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Vérifié</span>
                                <?php else: ?>
                                    <span class="badge bg-warning"><i class="bi bi-clock"></i> En attente</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?php echo e(route('super-admin.users.show', $user)); ?>" class="btn btn-outline-primary" title="Voir les détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if($user->id !== auth()->id()): ?>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo e($user->id); ?>" title="Supprimer l'utilisateur">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de suppression -->
                        <?php if($user->id !== auth()->id()): ?>
                            <div class="modal fade" id="deleteModal<?php echo e($user->id); ?>" tabindex="-1">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Confirmer la suppression</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0">Êtes-vous sûr de vouloir supprimer <strong><?php echo e($user->full_name); ?></strong> (<?php echo e($user->email); ?>) ?</p>
                                            <p class="text-danger small mt-2"><i class="bi bi-exclamation-triangle"></i> Cette action est irréversible.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <form method="POST" action="<?php echo e(route('super-admin.users.destroy', $user)); ?>" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                                <p class="text-muted mt-2">Aucun utilisateur trouvé</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            <?php echo e($users->appends(request()->query())->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .btn-group-sm .btn {
        padding: 0.375rem 0.75rem;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/super-admin/users/index.blade.php ENDPATH**/ ?>