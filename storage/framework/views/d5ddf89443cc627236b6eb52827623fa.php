

<?php $__env->startSection('title', ($currentCategory ? $currentCategory->name . ' - ' : '') . $shop->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Category Header -->
    <?php if($currentCategory): ?>
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain])); ?>">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?php echo e($currentCategory->name); ?>

                        </li>
                    </ol>
                </nav>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <?php if($currentCategory->image): ?>
                                <div class="col-md-2 text-center">
                                    <img src="<?php echo e(Storage::url($currentCategory->image)); ?>" 
                                         alt="<?php echo e($currentCategory->name); ?>" 
                                         class="img-fluid rounded" 
                                         style="max-height: 120px; object-fit: cover;">
                                </div>
                                <div class="col-md-10">
                            <?php else: ?>
                                <div class="col-12">
                            <?php endif; ?>
                                <h1 class="mb-2"><?php echo e($currentCategory->name); ?></h1>
                                <?php if($currentCategory->description): ?>
                                    <p class="text-muted mb-0"><?php echo e($currentCategory->description); ?></p>
                                <?php endif; ?>
                                <div class="mt-2">
                                    <span class="badge bg-primary"><?php echo e($products->count()); ?> produit<?php echo e($products->count() > 1 ? 's' : ''); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row mb-4">
            <div class="col-12">
                <h1>Tous les produits</h1>
                <p class="text-muted">Découvrez tous nos produits</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Category Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-tags me-2"></i>
                        Catégories
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain])); ?>" 
                           class="btn btn-sm <?php echo e(!$currentCategory ? 'btn-primary' : 'btn-outline-primary'); ?>">
                            Tous les produits
                        </a>
                        <?php $__currentLoopData = $shop->categories()->where('is_active', true)->orderBy('order')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain, 'category' => $category->slug])); ?>" 
                               class="btn btn-sm <?php echo e(($currentCategory && $currentCategory->id === $category->id) ? 'btn-primary' : 'btn-outline-primary'); ?>">
                                <?php echo e($category->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <?php if($products->count() > 0): ?>
        <div class="row">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 product-card border-0 shadow-sm hover-lift">
                        <!-- Product Image -->
                        <div class="position-relative">
                            <?php if($product->image): ?>
                                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo e($product->name); ?>"
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($product->isInStock()): ?>
                                <span class="position-absolute top-0 start-0 m-2 badge bg-success">En stock</span>
                            <?php else: ?>
                                <span class="position-absolute top-0 start-0 m-2 badge bg-danger">Rupture</span>
                            <?php endif; ?>
                            
                            <?php if($product->category): ?>
                                <span class="position-absolute top-0 end-0 m-2 badge bg-primary">
                                    <?php echo e($product->category->name); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Product Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2">
                                <a href="<?php echo e(route('shop.product', ['subdomain' => $shop->subdomain, 'id' => $product->id])); ?>" 
                                   class="text-decoration-none text-dark">
                                    <?php echo e(Str::limit($product->name, 50)); ?>

                                </a>
                            </h5>
                            
                            <?php if($product->short_description): ?>
                                <p class="card-text text-muted small flex-grow-1">
                                    <?php echo e(Str::limit($product->short_description, 80)); ?>

                                </p>
                            <?php elseif($product->description): ?>
                                <p class="card-text text-muted small flex-grow-1">
                                    <?php echo e(Str::limit(strip_tags($product->description), 80)); ?>

                                </p>
                            <?php endif; ?>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="h5 text-primary mb-0"><?php echo e($product->formatted_price); ?></span>
                                    </div>
                                    <div>
                                        <?php if($product->isInStock()): ?>
                                            <button class="btn btn-sm btn-primary add-to-cart" 
                                                    data-product-id="<?php echo e($product->id); ?>">
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-outline-secondary" disabled>
                                                <i class="bi bi-cart-x"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <!-- Pagination -->
        <?php if($products instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <?php echo e($products->links()); ?>

                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="row">
            <div class="col-12 text-center py-5">
                <i class="bi bi-box-seam" style="font-size: 4rem; color: #ccc;"></i>
                <h3 class="mt-3">Aucun produit disponible</h3>
                <p class="text-muted">
                    <?php if($currentCategory): ?>
                        Il n'y a aucun produit dans la catégorie "<?php echo e($currentCategory->name); ?>" pour le moment.
                    <?php else: ?>
                        Aucun produit n'est disponible dans cette boutique.
                    <?php endif; ?>
                </p>
                <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain])); ?>" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-1"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.hover-lift {
    transition: transform 0.2s ease-in-out;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.product-card {
    transition: all 0.2s ease-in-out;
}

.product-card:hover {
    transform: translateY(-2px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const quantity = 1;
            const buttonElement = this;
            
            // Show loading state
            const originalHtml = buttonElement.innerHTML;
            buttonElement.innerHTML = '<i class="bi bi-arrow-clockwise fa-spin"></i>';
            buttonElement.disabled = true;
            
            // Make AJAX request to add to cart
            fetch('<?php echo e(route("shop.cart.add", ["subdomain" => $shop->subdomain])); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity)
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Show success feedback
                    buttonElement.innerHTML = '<i class="bi bi-check"></i>';
                    buttonElement.classList.remove('btn-primary');
                    buttonElement.classList.add('btn-success');
                    
                    // Update cart count in navigation if exists
                    document.querySelectorAll('.cart-count').forEach(element => {
                        element.textContent = data.cart_count;
                    });
                    
                    // Reset button after delay
                    setTimeout(() => {
                        buttonElement.innerHTML = originalHtml;
                        buttonElement.disabled = false;
                        buttonElement.classList.remove('btn-success');
                        buttonElement.classList.add('btn-primary');
                    }, 2000);
                } else {
                    alert(data.message || 'Erreur lors de l\'ajout au panier');
                    buttonElement.innerHTML = originalHtml;
                    buttonElement.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur s\'est produite lors de l\'ajout au panier');
                buttonElement.innerHTML = originalHtml;
                buttonElement.disabled = false;
            });
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('shop.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\shop\category-products.blade.php ENDPATH**/ ?>