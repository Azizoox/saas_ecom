<?php $__env->startSection('title', 'Builder — Page d\'accueil'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .builder-page {
        --builder-radius: 14px;
        --builder-radius-sm: 10px;
        --builder-shadow: 0 2px 12px -2px rgba(0,0,0,.08), 0 4px 8px -4px rgba(0,0,0,.04);
        --builder-shadow-hover: 0 8px 24px -4px rgba(0,0,0,.1), 0 4px 12px -4px rgba(0,0,0,.06);
        --builder-sidebar-bg: #f8fafc;
        --builder-border: rgba(0,0,0,.06);
    }
    .builder-page .section-label {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 0.75rem;
    }
    .builder-page .builder-sidebar {
        background: var(--builder-sidebar-bg);
        border-radius: var(--builder-radius);
        padding: 1.25rem;
        position: sticky;
        top: 1rem;
        border: 1px solid var(--builder-border);
    }
    .builder-page .component-type-card {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 1.1rem;
        border: 1px solid var(--builder-border);
        border-radius: var(--builder-radius-sm);
        background: #fff;
        cursor: pointer;
        transition: all .2s ease;
        text-align: left;
        width: 100%;
        margin-bottom: 0.6rem;
    }
    .builder-page .component-type-card:hover {
        border-color: rgba(99, 102, 241, .35);
        box-shadow: var(--builder-shadow-hover);
        transform: translateY(-1px);
    }
    .builder-page .component-type-card .type-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .builder-page .component-type-card .type-title { font-weight: 600; font-size: 0.95rem; margin-bottom: 0.2rem; }
    .builder-page .component-type-card .type-desc { font-size: 0.8rem; color: #64748b; }
    .builder-page .help-card {
        background: #fff;
        border: 1px solid var(--builder-border);
        border-radius: var(--builder-radius-sm);
        padding: 1rem 1.1rem;
        margin-top: 1.25rem;
    }
    .builder-page .help-card .help-title { font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 0.6rem; }
    .builder-page .help-card ul { font-size: 0.8rem; color: #64748b; padding-left: 1.1rem; margin: 0; }
    .builder-page .canvas-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .builder-page .canvas-title { font-size: 1.25rem; font-weight: 700; margin: 0; color: #0f172a; }
    .builder-page .canvas-subtitle { font-size: 0.85rem; color: #64748b; margin-top: 0.25rem; }
    .builder-page .shop-select-wrap {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .builder-page .shop-select-wrap label { font-size: 0.8rem; color: #64748b; margin: 0; white-space: nowrap; }
    .builder-page .shop-select-wrap .form-select {
        min-width: 180px;
        border-radius: var(--builder-radius-sm);
        border-color: var(--builder-border);
        font-size: 0.9rem;
    }
    .builder-page .btn-preview {
        border-radius: var(--builder-radius-sm);
        font-weight: 500;
        font-size: 0.875rem;
    }
    .builder-page .empty-canvas {
        background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        border: 2px dashed #cbd5e1;
        border-radius: var(--builder-radius);
        padding: 3.5rem 2rem;
        text-align: center;
    }
    .builder-page .empty-canvas .empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: #e2e8f0;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.25rem;
        margin: 0 auto 1.5rem;
    }
    .builder-page .empty-canvas .empty-title { font-size: 1.15rem; font-weight: 700; color: #334155; margin-bottom: 0.5rem; }
    .builder-page .empty-canvas .empty-desc { font-size: 0.9rem; color: #64748b; max-width: 360px; margin: 0 auto 1.5rem; }
    .builder-page .component-block {
        background: #fff;
        border: 1px solid var(--builder-border);
        border-radius: var(--builder-radius);
        box-shadow: var(--builder-shadow);
        margin-bottom: 1rem;
        overflow: hidden;
        transition: box-shadow .2s ease;
    }
    .builder-page .component-block:hover { box-shadow: var(--builder-shadow-hover); }
    .builder-page .component-block.sortable-ghost { opacity: .45; transform: scale(0.98); }
    .builder-page .component-block.sortable-chosen { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99, 102, 241, .2); }
    .builder-page .component-block.sortable-drag { box-shadow: 0 12px 32px -8px rgba(0,0,0,.15); opacity: 1; }
    .builder-page .component-block .block-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: #fafbfc;
        border-bottom: 1px solid var(--builder-border);
        flex-wrap: wrap;
    }
    .builder-page .component-block .block-handle {
        cursor: grab;
        color: #94a3b8;
        font-size: 1.1rem;
        padding: 0.25rem;
        border-radius: 6px;
    }
    .builder-page .component-block .block-handle:hover { color: #6366f1; background: rgba(99, 102, 241, .08); }
    .builder-page .component-block .block-handle:active { cursor: grabbing; }
    .builder-page .component-block .block-type-badge {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 0.35rem 0.65rem;
        border-radius: 8px;
    }
    .builder-page .component-block .block-summary { font-size: 0.85rem; color: #64748b; }
    .builder-page .component-block .block-actions { margin-left: auto; display: flex; align-items: center; gap: 0.5rem; }
    .builder-page .component-block .block-form-wrap {
        padding: 1.25rem 1.5rem;
        background: #fff;
        border-top: 1px solid var(--builder-border);
    }
    .builder-page .component-block .block-form-inner {
        background: #f8fafc;
        border-radius: var(--builder-radius-sm);
        padding: 1.25rem 1.5rem;
        border: 1px solid var(--builder-border);
    }
    .builder-page .add-modal .modal-content { border-radius: var(--builder-radius); border: none; box-shadow: 0 24px 48px -12px rgba(0,0,0,.18); }
    .builder-page .add-modal .modal-header {
        border-bottom: 1px solid var(--builder-border);
        padding: 1.25rem 1.5rem;
        background: #fff;
    }
    .builder-page .add-modal .modal-title { font-weight: 700; font-size: 1.1rem; }
    .builder-page .add-modal .modal-body { padding: 1.5rem 1.5rem; }
    .builder-page .add-modal .modal-footer { border-top: 1px solid var(--builder-border); padding: 1rem 1.5rem; }
    .builder-page .add-modal .modal-icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin: 0 auto 1rem;
    }
    .builder-page .toast-holder { z-index: 9999; }

    /* Delete confirmation modal (pro) */
    .builder-page .delete-modal-content { border-radius: 16px; overflow: hidden; }
    .builder-page .delete-modal-icon-wrap {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.12);
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto;
    }
    .builder-page .delete-modal-content .modal-title { font-weight: 700; font-size: 1.1rem; }
    .builder-page .delete-modal-content .btn-delete-confirm {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.6rem 1rem;
    }
    .builder-page .delete-modal-content .btn-outline-secondary { border-radius: 10px; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="builder-page">
    <div class="container-fluid px-3 px-md-4">
        <div class="row g-4">
            
            <div class="col-lg-4 col-xl-3">
                <div class="builder-sidebar">
                    <p class="section-label">Ajouter un bloc</p>
                    <button type="button" class="component-type-card border-0 shadow-none" data-bs-toggle="modal" data-bs-target="#addComponentModal" data-type="slider">
                        <div class="type-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-images"></i></div>
                        <div>
                            <div class="type-title">Slider / Carousel</div>
                            <div class="type-desc">Diaporama d'images</div>
                        </div>
                    </button>
                    <button type="button" class="component-type-card border-0 shadow-none" data-bs-toggle="modal" data-bs-target="#addComponentModal" data-type="categories">
                        <div class="type-icon bg-success bg-opacity-10 text-success"><i class="bi bi-grid-3x3-gap"></i></div>
                        <div>
                            <div class="type-title">Catégories</div>
                            <div class="type-desc">Afficher les catégories</div>
                        </div>
                    </button>
                    <button type="button" class="component-type-card border-0 shadow-none" data-bs-toggle="modal" data-bs-target="#addComponentModal" data-type="premium_categories">
                        <div class="type-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-star-fill"></i></div>
                        <div>
                            <div class="type-title">Catégories Premium</div>
                            <div class="type-desc">Mise en avant spéciale</div>
                        </div>
                    </button>
                    <button type="button" class="component-type-card border-0 shadow-none" data-bs-toggle="modal" data-bs-target="#addComponentModal" data-type="banner">
                        <div class="type-icon bg-info bg-opacity-10 text-info"><i class="bi bi-megaphone"></i></div>
                        <div>
                            <div class="type-title">Bandeau défilant</div>
                            <div class="type-desc">Annonce animée</div>
                        </div>
                    </button>
                    <button type="button" class="component-type-card border-0 shadow-none" data-bs-toggle="modal" data-bs-target="#addComponentModal" data-type="reviews">
                        <div class="type-icon bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-chat-quote"></i></div>
                        <div>
                            <div class="type-title">Avis Clients</div>
                            <div class="type-desc">Témoignages</div>
                        </div>
                    </button>

                    <div class="help-card">
                        <div class="help-title"><i class="bi bi-lightbulb text-warning me-1"></i> Comment ça marche</div>
                        <ul>
                            <li>Cliquez sur un bloc pour l’ajouter</li>
                            <li>Glissez la poignée pour réorganiser</li>
                            <li>Modifiez le contenu puis enregistrez</li>
                        </ul>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-8 col-xl-9">
                <div class="canvas-header">
                    <div>
                        <h1 class="canvas-title"><i class="bi bi-layout-text-sidebar-reverse text-primary me-2"></i> Page d'accueil</h1>
                        <p class="canvas-subtitle"><i class="bi bi-grip-vertical me-1"></i> Glissez pour réorganiser l’ordre des blocs</p>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <?php if(isset($shops) && $shops->count() > 1): ?>
                            <form method="GET" action="<?php echo e(route('builder.index')); ?>" class="shop-select-wrap">
                                <label for="builderShopSelect">Boutique</label>
                                <select name="shop_id" id="activeShopId" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($s->id); ?>" <?php if($shop->id === $s->id): echo 'selected'; endif; ?>><?php echo e($s->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                        <?php else: ?>
                            <input type="hidden" id="activeShopId" value="<?php echo e($shop->id); ?>">
                        <?php endif; ?>
                        <a href="<?php echo e(route('shop.index', ['subdomain' => $shop->subdomain])); ?>" target="_blank" class="btn btn-outline-primary btn-preview">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Voir la page
                        </a>
                    </div>
                </div>

                <?php if($components->isEmpty()): ?>
                    <div class="empty-canvas">
                        <div class="empty-icon"><i class="bi bi-layout-text-sidebar-reverse"></i></div>
                        <h2 class="empty-title">Page vide</h2>
                        <p class="empty-desc">Ajoutez votre premier bloc depuis le menu à gauche pour construire la page d’accueil de votre boutique.</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addComponentModal" data-type="slider">
                            <i class="bi bi-plus-lg me-2"></i> Ajouter un bloc
                        </button>
                    </div>
                <?php else: ?>
                    <div id="components-list">
                        <?php $__currentLoopData = $components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="component-block component-item" data-id="<?php echo e($component->id); ?>">
                                <div class="block-header">
                                    <span class="block-handle" title="Glisser pour réorganiser"><i class="bi bi-grip-vertical"></i></span>
                                    <span class="block-type-badge bg-<?php echo e($component->type === 'slider' ? 'primary' : ($component->type === 'categories' ? 'success' : ($component->type === 'premium_categories' ? 'warning' : ($component->type === 'banner' ? 'info' : 'secondary')))); ?> bg-opacity-10 text-<?php echo e($component->type === 'slider' ? 'primary' : ($component->type === 'categories' ? 'success' : ($component->type === 'premium_categories' ? 'warning' : ($component->type === 'banner' ? 'info' : 'secondary')))); ?>">
                                        <?php echo e(str_replace('_', ' ', $component->type)); ?>

                                    </span>
                                    <?php if(!$component->is_active): ?>
                                        <span class="badge bg-secondary">Inactif</span>
                                    <?php endif; ?>
                                    <span class="block-summary">
                                        <?php switch($component->type):
                                            case ('slider'): ?> <?php echo e(count($component->content['slides'] ?? [])); ?> slide(s) <?php break; ?>
                                            <?php case ('categories'): ?> Style : <?php echo e($component->content['style'] ?? 'grid'); ?> <?php break; ?>
                                            <?php case ('reviews'): ?> <?php echo e(count($component->content['reviews'] ?? [])); ?> avis <?php break; ?>
                                            <?php default: ?> Configuré
                                        <?php endswitch; ?>
                                    </span>
                                    <div class="block-actions">
                                        <form action="<?php echo e(route('builder.destroy', $component)); ?>" method="POST" class="d-inline delete-component-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-trigger-delete" title="Supprimer" data-delete-title="Supprimer ce bloc ?" data-delete-message="Cette action est irréversible. Le composant sera définitivement supprimé de votre page d'accueil.">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="block-form-wrap">
                                    <form action="<?php echo e(route('builder.update', $component)); ?>" method="POST" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="form-check form-switch mb-4">
                                            <input class="form-check-input" type="checkbox" name="is_active" id="active-<?php echo e($component->id); ?>" <?php echo e($component->is_active ? 'checked' : ''); ?>>
                                            <label class="form-check-label fw-semibold" for="active-<?php echo e($component->id); ?>">Bloc visible sur la page</label>
                                        </div>
                                        <div class="block-form-inner">
                                            <?php echo $__env->make('dashboard.builder.partials.' . $component->type, [
                                                'content' => $component->content,
                                                'componentId' => $component->id,
                                            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-check-lg me-1"></i> Enregistrer
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content delete-modal-content border-0 shadow-lg">
            <div class="modal-body text-center p-4 p-md-5">
                <div class="delete-modal-icon-wrap mb-3">
                    <i class="bi bi-trash3"></i>
                </div>
                <h5 class="modal-title mb-2" id="deleteConfirmModalLabel">Supprimer ?</h5>
                <p class="text-muted small mb-4 delete-modal-message">Cette action est irréversible.</p>
                <div class="d-flex flex-column gap-2">
                    <button type="button" class="btn btn-danger btn-delete-confirm">
                        <i class="bi bi-trash me-2"></i> Supprimer
                    </button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade add-modal" id="addComponentModal" tabindex="-1" aria-labelledby="addComponentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addComponentModalLabel">Ajouter un bloc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form action="<?php echo e(route('builder.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="shop_id" id="shopIdInput" value="<?php echo e($shop->id); ?>">
                <input type="hidden" name="type" id="componentType">
                <div class="modal-body text-center">
                    <div id="modalIconWrap" class="modal-icon-wrap bg-primary bg-opacity-10 text-primary">
                        <i id="modalIcon" class="bi bi-plus-lg"></i>
                    </div>
                    <h5 id="modalTitle" class="mb-2">Choisir un type</h5>
                    <p id="modalDescription" class="text-muted small mb-4">Le bloc sera ajouté en bas de la page d'accueil.</p>
                    <div class="alert alert-light border small mb-0 text-start">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Vous pourrez modifier le contenu et l'ordre après l'ajout.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Ajouter le bloc</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="toast-holder position-fixed top-0 end-0 p-3" aria-live="polite"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
(function() {
    // Delete confirmation modal (pro)
    const deleteModal = document.getElementById('deleteConfirmModal');
    const deleteModalTitle = deleteModal ? deleteModal.querySelector('#deleteConfirmModalLabel') : null;
    const deleteModalMessage = deleteModal ? deleteModal.querySelector('.delete-modal-message') : null;
    const deleteConfirmBtn = deleteModal ? deleteModal.querySelector('.btn-delete-confirm') : null;
    let formToSubmit = null;

    if (deleteModal && deleteConfirmBtn) {
        document.querySelectorAll('.btn-trigger-delete').forEach(function(btn) {
            btn.addEventListener('click', function() {
                formToSubmit = this.closest('form');
                if (deleteModalTitle) deleteModalTitle.textContent = this.getAttribute('data-delete-title') || 'Supprimer ?';
                if (deleteModalMessage) deleteModalMessage.textContent = this.getAttribute('data-delete-message') || 'Cette action est irréversible.';
                var m = new bootstrap.Modal(deleteModal);
                m.show();
            });
        });
        deleteConfirmBtn.addEventListener('click', function() {
            if (formToSubmit) formToSubmit.submit();
            bootstrap.Modal.getInstance(deleteModal).hide();
            formToSubmit = null;
        });
        deleteModal.addEventListener('hidden.bs.modal', function() { formToSubmit = null; });
    }

    const modal = document.getElementById('addComponentModal');
    const componentData = {
        slider:  { icon: 'bi-images',  title: 'Slider / Carousel',  desc: 'Diaporama d\'images avec titres et liens.', color: 'primary' },
        categories: { icon: 'bi-grid-3x3-gap', title: 'Catégories', desc: 'Grille ou slider de catégories.', color: 'success' },
        premium_categories: { icon: 'bi-star-fill', title: 'Catégories Premium', desc: 'Mise en avant avec badge.', color: 'warning' },
        banner:  { icon: 'bi-megaphone', title: 'Bandeau défilant', desc: 'Annonce animée en haut de page.', color: 'info' },
        reviews: { icon: 'bi-chat-quote', title: 'Avis Clients', desc: 'Témoignages et avis.', color: 'secondary' }
    };

    if (modal) {
        modal.addEventListener('show.bs.modal', function(e) {
            const btn = e.relatedTarget;
            const type = (btn && btn.getAttribute('data-type')) || 'slider';
            const data = componentData[type] || componentData.slider;
            document.getElementById('componentType').value = type;
            const shopEl = document.getElementById('activeShopId');
            if (shopEl) document.getElementById('shopIdInput').value = shopEl.value || '<?php echo e($shop->id); ?>';
            const wrap = document.getElementById('modalIconWrap');
            wrap.className = 'modal-icon-wrap bg-' + data.color + ' bg-opacity-10 text-' + data.color;
            wrap.innerHTML = '<i class="bi ' + data.icon + '"></i>';
            document.getElementById('modalTitle').textContent = data.title;
            document.getElementById('modalDescription').textContent = data.desc;
        });
    }

    const list = document.getElementById('components-list');
    if (list) {
        new Sortable(list, {
            handle: '.block-handle',
            animation: 180,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function() {
                const order = Array.from(list.querySelectorAll('.component-item')).map(el => el.dataset.id);
                fetch('<?php echo e(route("builder.reorder")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(r => r.json())
                .then(data => { if (data.success) showBuilderToast('Ordre enregistré', 'success'); })
                .catch(() => showBuilderToast('Erreur lors de la mise à jour', 'danger'));
            }
        });
    }

    window.showBuilderToast = function(message, type) {
        const holder = document.querySelector('.toast-holder');
        if (!holder) return;
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white border-0';
        toast.setAttribute('role', 'alert');
        toast.style.background = type === 'success' ? '#10b981' : (type === 'danger' ? '#ef4444' : '#6366f1');
        toast.innerHTML = '<div class="d-flex"><div class="toast-body"><i class="bi bi-' + (type === 'success' ? 'check-circle' : 'info-circle') + ' me-2"></i>' + message + '</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>';
        holder.appendChild(toast);
        new bootstrap.Toast(toast, { delay: 4000 }).show();
        toast.addEventListener('hidden.bs.toast', function() { toast.remove(); });
    };
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/dashboard/builder/index.blade.php ENDPATH**/ ?>