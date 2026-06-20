<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<?php $__env->startSection('title', 'Ajouter un produit'); ?>

<?php $__env->startSection('content'); ?>


<div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 small">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>" class="text-decoration-none text-muted">Produits</a></li>
                <li class="breadcrumb-item active text-dark fw-medium">Nouveau produit</li>
            </ol>
        </nav>
        <h4 class="mb-0 fw-semibold text-dark">
            <i class="bi bi-bag-plus me-2 text-primary"></i>Ajouter un produit
        </h4>
    </div>
    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary btn-sm px-3">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
    <div class="d-flex align-items-start gap-2">
        <i class="bi bi-exclamation-triangle-fill mt-1 flex-shrink-0"></i>
        <div>
            <strong class="d-block mb-1">Veuillez corriger les erreurs suivantes :</strong>
            <ul class="mb-0 ps-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="small"><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('products.store')); ?>" enctype="multipart/form-data" id="productForm">
    <?php echo csrf_field(); ?>

    <div class="row g-4">

        
        <div class="col-lg-8">

            
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-bottom border-light px-4 py-3">
                    <h6 class="mb-0 fw-semibold text-dark d-flex align-items-center gap-2">
                        <span class="bg-primary bg-opacity-10 text-primary rounded-2 p-1 lh-1">
                            <i class="bi bi-info-circle" style="font-size:.85rem;"></i>
                        </span>
                        Informations générales
                    </h6>
                </div>
                <div class="card-body px-4 py-4">

                    
                    <div class="row g-3 mb-3">
                        
                        <input type="hidden" name="shop_id" value="<?php echo e(Auth::user()->shop->id); ?>">
                        <div class="col-md-6">
                            <label for="category_id" class="form-label fw-medium small text-secondary">Catégorie</label>
                            <select class="form-select form-select-sm <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="category_id" name="category_id">
                                <option value="">— Aucune catégorie —</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"
                                        data-shop-id="<?php echo e($category->shop_id); ?>"
                                        <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback small"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label fw-medium small text-secondary">Nom du produit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="ex: T-shirt coton bio" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback small"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label for="sku" class="form-label fw-medium small text-secondary">SKU</label>
                            <input type="text" class="form-control form-control-sm <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sku" name="sku" value="<?php echo e(old('sku')); ?>" placeholder="ex: TSHIRT-001">
                            <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback small"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="reference" class="form-label fw-medium small text-secondary">Référence</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-hash"></i></span>
                                <input type="text" class="form-control border-start-0 <?php $__errorArgs = ['reference'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="reference" name="reference" value="<?php echo e(old('reference')); ?>" placeholder="REF-XXXX">
                            </div>
                            <?php $__errorArgs = ['reference'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label for="barcode" class="form-label fw-medium small text-secondary">Code à barre (EAN/UPC)</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-upc-scan"></i></span>
                                <input type="text" class="form-control border-start-0 <?php $__errorArgs = ['barcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="barcode" name="barcode" value="<?php echo e(old('barcode')); ?>" placeholder="ex: 1234567890123">
                            </div>
                            <?php $__errorArgs = ['barcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="supplier" class="form-label fw-medium small text-secondary">Fournisseur principal</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-truck"></i></span>
                                <input type="text" class="form-control border-start-0 <?php $__errorArgs = ['supplier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="supplier" name="supplier" value="<?php echo e(old('supplier')); ?>" list="suppliers" placeholder="Saisir ou choisir">
                                <datalist id="suppliers">
                                    <option value="Fournisseur A">
                                    <option value="Fournisseur B">
                                    <option value="Fournisseur C">
                                </datalist>
                            </div>
                            <?php $__errorArgs = ['supplier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label for="brand" class="form-label fw-medium small text-secondary">Marque</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 text-secondary"><i class="bi bi-award"></i></span>
                                <input type="text" class="form-control border-start-0 <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="brand" name="brand" value="<?php echo e(old('brand')); ?>" list="brands" placeholder="Saisir ou choisir">
                                <datalist id="brands">
                                    <option value="Marque A">
                                    <option value="Marque B">
                                    <option value="Marque C">
                                </datalist>
                            </div>
                            <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                </div>
            </div>

            
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-bottom border-light px-4 py-3">
                    <h6 class="mb-0 fw-semibold text-dark d-flex align-items-center gap-2">
                        <span class="bg-info bg-opacity-10 text-info rounded-2 p-1 lh-1">
                            <i class="bi bi-card-text" style="font-size:.85rem;"></i>
                        </span>
                        Descriptions
                    </h6>
                </div>
                <div class="card-body px-4 py-4">

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="editor" class="form-label fw-medium small text-secondary mb-0">Description courte</label>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary fw-normal small">Max. 500 caractères</span>
                        </div>
                        <textarea class="form-control <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="editor" name="short_description" rows="3" maxlength="500"><?php echo e(old('short_description')); ?></textarea>
                        <div class="form-text text-muted small mt-1">
                            <i class="bi bi-lightbulb me-1"></i>Résumé rapide du produit — avantages clés en 1-2 phrases.
                        </div>
                        <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback small"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="edi" class="form-label fw-medium small text-secondary mb-0">Description longue</label>
                            <span class="badge bg-info bg-opacity-10 text-info fw-normal small">Éditeur riche</span>
                        </div>
                        <textarea style="height:300px;" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="edi" name="description" rows="12"><?php echo e(old('description')); ?></textarea>
                        <div class="form-text text-muted small mt-1">
                            <i class="bi bi-info-circle me-1"></i>Description détaillée : caractéristiques, usage, bénéfices.
                        </div>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback small"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>
            </div>

            
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-bottom border-light px-4 py-3">
                    <h6 class="mb-0 fw-semibold text-dark d-flex align-items-center gap-2">
                        <span class="bg-success bg-opacity-10 text-success rounded-2 p-1 lh-1">
                            <i class="bi bi-images" style="font-size:.85rem;"></i>
                        </span>
                        Images du produit
                    </h6>
                </div>
                <div class="card-body px-4 py-4">

                    
                    <div class="mb-4">
                        <label for="image" class="form-label fw-medium small text-secondary">Image principale <span class="text-danger">*</span></label>
                        <div class="border rounded-3 p-3 bg-light" id="mainImageWrap">
                            <input type="file" class="form-control form-control-sm <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="image" name="image" accept="image/*">
                            <div class="form-text text-muted small mt-2">
                                <i class="bi bi-file-image me-1"></i>Formats acceptés : JPG, PNG, WEBP — Taille recommandée : 800×800px
                            </div>
                        </div>
                        <div id="mainImagePreviewWrap" class="mt-2 d-none">
                            <p class="small text-muted mb-1">Aperçu :</p>
                            <img id="mainImagePreview" src="#" class="img-thumbnail rounded-3" style="width:120px;height:120px;object-fit:cover;" alt="Aperçu">
                        </div>
                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div>
                        <label class="form-label fw-medium small text-secondary">Galerie d'images</label>
                        <div class="border border-2 border-dashed rounded-3 p-4 text-center bg-light" id="imageGallery" style="cursor:pointer;transition:background .2s;">
                            <div class="text-muted mb-2">
                                <i class="bi bi-cloud-arrow-up-fill" style="font-size:2rem; opacity:.5;"></i>
                            </div>
                            <p class="mb-1 fw-medium text-secondary small">Glissez-déposez vos images ici</p>
                            <p class="text-muted small mb-0">ou <span class="text-primary text-decoration-underline">parcourez vos fichiers</span></p>
                            <input type="file" class="d-none" id="galleryInput" name="gallery[]" multiple accept="image/*">
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-3" id="galleryPreview"></div>
                    </div>

                </div>
            </div>

            
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-bottom border-light px-4 py-3">
                    <h6 class="mb-0 fw-semibold text-dark d-flex align-items-center gap-2">
                        <span class="bg-warning bg-opacity-10 text-warning rounded-2 p-1 lh-1">
                            <i class="bi bi-grid-3x3-gap" style="font-size:.85rem;"></i>
                        </span>
                        Variantes &amp; Combinaisons
                    </h6>
                </div>
                <div class="card-body px-4 py-4">

                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-medium small text-secondary mb-1">Attribut</label>
                            <select class="form-select form-select-sm" id="variantAttribute">
                                <option value="">— Choisir —</option>
                                <option value="taille">Taille</option>
                                <option value="couleur">Couleur</option>
                                <option value="matiere">Matière</option>
                                <option value="poids">Poids</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium small text-secondary mb-1">Valeur</label>
                            <input type="text" class="form-control form-control-sm" id="variantValue" placeholder="ex: S, M, L — Rouge, Bleu…">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary btn-sm w-100" id="addVariantBtn">
                                <i class="bi bi-plus-lg me-1"></i>Ajouter
                            </button>
                        </div>
                    </div>

                    <div id="variantsList" class="mt-3 d-flex flex-wrap gap-2"></div>
                    <p id="variantsEmpty" class="text-muted small mt-3 mb-0 fst-italic">
                        <i class="bi bi-info-circle me-1"></i>Aucune variante ajoutée. Les variantes permettent de gérer plusieurs déclinaisons d'un même produit.
                    </p>

                </div>
            </div>

            
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-bottom border-light px-4 py-3">
                    <h6 class="mb-0 fw-semibold text-dark d-flex align-items-center gap-2">
                        <span class="bg-secondary bg-opacity-10 text-secondary rounded-2 p-1 lh-1">
                            <i class="bi bi-collection" style="font-size:.85rem;"></i>
                        </span>
                        Groupe de produits
                    </h6>
                </div>
                <div class="card-body px-4 py-4">
                    <label for="product_group_id" class="form-label fw-medium small text-secondary">Groupe de produits</label>
                    <select class="form-select form-select-sm <?php $__errorArgs = ['product_group_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="product_group_id" name="product_group_id">
                        <option value="">— Aucun groupe —</option>
                        
                    </select>
                    <div class="form-text text-muted small mt-1">
                        <i class="bi bi-link-45deg me-1"></i>Lier ce produit à un groupe existant pour regrouper des variantes.
                    </div>
                    <?php $__errorArgs = ['product_group_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback small"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

        </div>

        
        <div class="col-lg-4">

            
            <div class="card border-0 shadow-sm rounded-3 mb-4 border-start border-primary border-3">
                <div class="card-header bg-white border-bottom border-light px-4 py-3">
                    <h6 class="mb-0 fw-semibold text-dark d-flex align-items-center gap-2">
                        <span class="bg-primary bg-opacity-10 text-primary rounded-2 p-1 lh-1">
                            <i class="bi bi-currency-dollar" style="font-size:.85rem;"></i>
                        </span>
                        Prix &amp; Stock
                    </h6>
                </div>
                <div class="card-body px-4 py-4">

                    <div class="mb-3">
                        <label for="price" class="form-label fw-medium small text-secondary">Prix <span class="text-danger">*</span></label>
                        <div class="input-group input-group-sm">
                            <input type="number" step="0.01" min="0" class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="price" name="price" value="<?php echo e(old('price')); ?>" placeholder="0.00" required>
                            <span class="input-group-text bg-light fw-medium">TND</span>
                        </div>
                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-4">
                        <label for="stock" class="form-label fw-medium small text-secondary">Stock <span class="text-danger">*</span></label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light text-secondary"><i class="bi bi-boxes"></i></span>
                            <input type="number" min="0" class="form-control <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="stock" name="stock" value="<?php echo e(old('stock', 0)); ?>" required>
                            <span class="input-group-text bg-light text-muted">unités</span>
                        </div>
                        <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?> role="switch">
                        <label class="form-check-label small text-secondary" for="is_active">
                            Produit actif <span class="text-muted">(visible en boutique)</span>
                        </label>
                    </div>

                </div>
            </div>

            
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white border-bottom border-light px-4 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold text-dark d-flex align-items-center gap-2">
                        <span class="bg-success bg-opacity-10 text-success rounded-2 p-1 lh-1">
                            <i class="bi bi-search" style="font-size:.85rem;"></i>
                        </span>
                        Référencement (SEO)
                    </h6>
                    <span class="badge bg-success bg-opacity-10 text-success fw-normal small border border-success border-opacity-25">Recommandé</span>
                </div>
                <div class="card-body px-4 py-4">

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="meta_title" class="form-label fw-medium small text-secondary mb-0">Titre meta</label>
                            <span class="small text-muted" id="metaTitleCount">0 / 60</span>
                        </div>
                        <input type="text" class="form-control form-control-sm mt-1 <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="meta_title" name="meta_title" value="<?php echo e(old('meta_title')); ?>" maxlength="255" placeholder="Titre affiché dans Google…">
                        <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback small"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="meta_description" class="form-label fw-medium small text-secondary mb-0">Description meta</label>
                            <span class="small text-muted" id="metaDescCount">0 / 160</span>
                        </div>
                        <textarea class="form-control form-control-sm mt-1 <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="meta_description" name="meta_description" rows="3" maxlength="160" placeholder="Description affichée dans les résultats de recherche…"><?php echo e(old('meta_description')); ?></textarea>
                        <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback small"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label fw-medium small text-secondary">Mots-clés</label>
                        <input type="text" class="form-control form-control-sm <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="meta_keywords" name="meta_keywords" value="<?php echo e(old('meta_keywords')); ?>" placeholder="mot1, mot2, mot3…">
                        <div class="form-text text-muted small mt-1">Séparés par des virgules.</div>
                        <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="invalid-feedback small"><i class="bi bi-x-circle me-1"></i><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="border rounded-3 bg-white p-3 mt-3" id="seoPreview">
                        <p class="text-muted small mb-2 fw-medium">Aperçu Google</p>
                        <p class="text-primary small mb-1 fw-medium text-truncate" id="seoPreviewTitle" style="font-size:.85rem;">Titre du produit</p>
                        <p class="text-success" style="font-size:.7rem; margin-bottom:4px;">https://votresite.com/produits/...</p>
                        <p class="text-secondary mb-0" style="font-size:.75rem;" id="seoPreviewDesc">La description meta apparaîtra ici.</p>
                    </div>

                </div>
            </div>

            
            <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top:1rem;">
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-sm py-2 fw-medium">
                            <i class="bi bi-check2-circle me-2"></i>Créer le produit
                        </button>
                        <button type="submit" name="redirect_after" value="edit" class="btn btn-outline-primary btn-sm py-2 fw-medium">
                            <i class="bi bi-pencil-square me-2"></i>Créer et modifier
                        </button>
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary btn-sm py-2">
                            <i class="bi bi-x me-1"></i>Annuler
                        </a>
                    </div>
                    <p class="text-muted small text-center mb-0 mt-3">
                        <i class="bi bi-shield-check me-1 text-success"></i>Les données sont sauvegardées en sécurité.
                    </p>
                </div>
            </div>

        </div>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Image principale preview ──────────────────────────────
    const imageInput = document.getElementById('image');
    const previewWrap = document.getElementById('mainImagePreviewWrap');
    const previewImg  = document.getElementById('mainImagePreview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                previewWrap.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // ── Galerie d'images ──────────────────────────────────────
    const dropzone     = document.getElementById('imageGallery');
    const galleryInput = document.getElementById('galleryInput');
    const galleryPreview = document.getElementById('galleryPreview');

    dropzone.addEventListener('click', () => galleryInput.click());

    dropzone.addEventListener('dragover', e => {
        e.preventDefault();
        dropzone.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
    });

    dropzone.addEventListener('drop', e => {
        e.preventDefault();
        dropzone.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
        const files = e.dataTransfer.files;
        if (files.length) {
            galleryInput.files = files;
            previewGallery(files);
        }
    });

    galleryInput.addEventListener('change', () => previewGallery(galleryInput.files));

    function previewGallery(files) {
        galleryPreview.innerHTML = '';
        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.className = 'position-relative';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'rounded-2 border';
                img.style.cssText = 'width:80px;height:80px;object-fit:cover;';

                const badge = document.createElement('button');
                badge.type = 'button';
                badge.innerHTML = '<i class="bi bi-x"></i>';
                badge.className = 'btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle p-0 d-flex align-items-center justify-content-center';
                badge.style.cssText = 'width:18px;height:18px;font-size:10px;transform:translate(40%,-40%);';
                badge.onclick = () => wrapper.remove();

                wrapper.appendChild(img);
                wrapper.appendChild(badge);
                galleryPreview.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }

    // ── Variantes ──────────────────────────────────────────────
    const addVariantBtn = document.getElementById('addVariantBtn');
    const variantsList  = document.getElementById('variantsList');
    const emptyMsg      = document.getElementById('variantsEmpty');
    let variants = [];

    addVariantBtn.addEventListener('click', () => {
        const attribute = document.getElementById('variantAttribute').value;
        const value     = document.getElementById('variantValue').value.trim();
        if (attribute && value) {
            variants.push({ attribute, value });
            renderVariants();
            document.getElementById('variantValue').value = '';
        }
    });

    function renderVariants() {
        variantsList.innerHTML = '';
        emptyMsg.style.display = variants.length ? 'none' : '';

        variants.forEach((v, i) => {
            const badge = document.createElement('span');
            badge.className = 'badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill fw-normal';
            badge.style.fontSize = '.8rem';
            badge.innerHTML = `
                <i class="bi bi-tag" style="font-size:.75rem;"></i>
                <span>${v.attribute}: <strong>${v.value}</strong></span>
                <button type="button" onclick="removeVariant(${i})" class="btn-close btn-close-sm ms-1" style="font-size:.55rem;" aria-label="Supprimer"></button>
            `;
            variantsList.appendChild(badge);
        });

        // Champ caché
        let hiddenInput = document.querySelector('input[name="variants"]');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'variants';
            document.getElementById('productForm').appendChild(hiddenInput);
        }
        hiddenInput.value = JSON.stringify(variants);
    }

    window.removeVariant = function(index) {
        variants.splice(index, 1);
        renderVariants();
    };

    // ── SEO Preview & Counter ──────────────────────────────────
    const metaTitleInput = document.getElementById('meta_title');
    const metaDescInput  = document.getElementById('meta_description');
    const seoTitle       = document.getElementById('seoPreviewTitle');
    const seoDesc        = document.getElementById('seoPreviewDesc');
    const titleCount     = document.getElementById('metaTitleCount');
    const descCount      = document.getElementById('metaDescCount');
    const nameInput      = document.getElementById('name');

    function updateSEO() {
        const title = metaTitleInput.value || nameInput.value || 'Titre du produit';
        const desc  = metaDescInput.value  || 'La description meta apparaîtra ici.';
        seoTitle.textContent = title.length > 60 ? title.slice(0, 57) + '…' : title;
        seoDesc.textContent  = desc.length  > 160 ? desc.slice(0, 157) + '…' : desc;
        titleCount.textContent = metaTitleInput.value.length + ' / 60';
        descCount.textContent  = metaDescInput.value.length  + ' / 160';
        titleCount.className = metaTitleInput.value.length > 60 ? 'small text-danger' : 'small text-muted';
        descCount.className  = metaDescInput.value.length  > 160 ? 'small text-danger' : 'small text-muted';
    }

    [metaTitleInput, metaDescInput, nameInput].forEach(el => el.addEventListener('input', updateSEO));
    updateSEO();

    const shopSelect     = document.getElementById('shop_id');
    const categorySelect = document.getElementById('category_id');

    shopSelect.addEventListener('change', function () {
        const shopId = this.value;
        Array.from(categorySelect.options).forEach(opt => {
            if (!opt.value) return;
            opt.hidden = shopId && opt.dataset.shopId !== shopId;
        });
        categorySelect.value = '';
    });

});
</script>


<script>
ClassicEditor.create(document.querySelector('#editor'), {
    toolbar: ['undo','redo','|','bold','italic','underline','strikethrough',
              '|','fontSize','fontColor','fontBackgroundColor',
              '|','link','insertImage','blockQuote',
              '|','bulletedList','numberedList','|','alignment','|','sourceEditing']
}).catch(console.error);

ClassicEditor.create(document.querySelector('#edi'), {
    toolbar: ['undo','redo','|','bold','italic','underline','strikethrough',
              '|','fontSize','fontColor','fontBackgroundColor',
              '|','link','insertImage','blockQuote',
              '|','bulletedList','numberedList','|','alignment','|','sourceEditing']
}).catch(console.error);
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/products/create_advanced.blade.php ENDPATH**/ ?>