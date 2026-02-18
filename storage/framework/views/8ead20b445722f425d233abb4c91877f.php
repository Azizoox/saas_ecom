<?php $__env->startSection('title', 'Gestion des produits'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-seam"></i> Mes produits</h2>
    <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Ajouter un produit
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <?php if($products->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Boutique</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($product->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                                <?php else: ?>
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 4px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo e($product->name); ?></strong>
                                <?php if($product->sku): ?>
                                    <br><small class="text-muted">SKU: <?php echo e($product->sku); ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($product->shop->name); ?></td>
                            <td><?php echo e($product->formatted_price); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($product->stock > 0 ? 'success' : 'danger'); ?>">
                                    <?php echo e($product->stock); ?>

                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo e($product->is_active ? 'success' : 'secondary'); ?>">
                                    <?php echo e($product->is_active ? 'Actif' : 'Inactif'); ?>

                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('products.edit', $product)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('products.destroy', $product)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <?php echo e($products->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-box-seam" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun produit pour le moment.</p>
                <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Ajouter votre premier produit
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/products/index.blade.php ENDPATH**/ ?>