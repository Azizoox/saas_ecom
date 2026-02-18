<div class="component-builder-section">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0"><i class="bi bi-images"></i> Slider / Carrousel</h5>
            <small>Créez un slider d'images avec titres, descriptions et boutons d'action</small>
        </div>
        <div class="card-body">
            <!-- Options du Slider -->
            <div class="mb-4">
                <h6 class="fw-bold text-primary border-bottom pb-2">
                    <i class="bi bi-sliders"></i> Configuration du Slider
                </h6>
                <div class="row g-3 mt-2">
                    <div class="col-md-3">
                        <div class="form-check form-switch p-3 bg-light rounded">
                            <input class="form-check-input" type="checkbox" name="content[options][autoplay]" 
                                   id="autoplay-<?php echo e($componentId); ?>" value="1" 
                                   <?php echo e(($content['options']['autoplay'] ?? true) ? 'checked' : ''); ?>>
                            <label class="form-check-label fw-bold" for="autoplay-<?php echo e($componentId); ?>">
                                <i class="bi bi-play-circle text-success"></i> Auto-play
                            </label>
                            <small class="d-block text-muted mt-1">Défilement automatique</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch p-3 bg-light rounded">
                            <input class="form-check-input" type="checkbox" name="content[options][loop]" 
                                   id="loop-<?php echo e($componentId); ?>" value="1" 
                                   <?php echo e(($content['options']['loop'] ?? true) ? 'checked' : ''); ?>>
                            <label class="form-check-label fw-bold" for="loop-<?php echo e($componentId); ?>">
                                <i class="bi bi-arrow-repeat text-info"></i> Boucle infinie
                            </label>
                            <small class="d-block text-muted mt-1">Retour au début</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch p-3 bg-light rounded">
                            <input class="form-check-input" type="checkbox" name="content[options][pagination]" 
                                   id="pagination-<?php echo e($componentId); ?>" value="1" 
                                   <?php echo e(($content['options']['pagination'] ?? true) ? 'checked' : ''); ?>>
                            <label class="form-check-label fw-bold" for="pagination-<?php echo e($componentId); ?>">
                                <i class="bi bi-circle text-primary"></i> Points de navigation
                            </label>
                            <small class="d-block text-muted mt-1">Indicateurs de slides</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check form-switch p-3 bg-light rounded">
                            <input class="form-check-input" type="checkbox" name="content[options][arrows]" 
                                   id="arrows-<?php echo e($componentId); ?>" value="1" 
                                   <?php echo e(($content['options']['arrows'] ?? true) ? 'checked' : ''); ?>>
                            <label class="form-check-label fw-bold" for="arrows-<?php echo e($componentId); ?>">
                                <i class="bi bi-arrow-left-right text-warning"></i> Flèches
                            </label>
                            <small class="d-block text-muted mt-1">Navigation prev/next</small>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-speedometer2"></i> Vitesse (ms)
                        </label>
                        <input type="number" name="content[options][speed]" class="form-control" 
                               value="<?php echo e($content['options']['speed'] ?? 3000); ?>" min="1000" max="10000" step="500">
                        <small class="text-muted">Durée d'affichage de chaque slide</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-arrows-angle-contract"></i> Transition (ms)
                        </label>
                        <input type="number" name="content[options][transition]" class="form-control" 
                               value="<?php echo e($content['options']['transition'] ?? 500); ?>" min="200" max="2000" step="100">
                        <small class="text-muted">Vitesse de transition entre slides</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            <i class="bi bi-aspect-ratio"></i> Hauteur du slider
                        </label>
                        <select name="content[options][height]" class="form-select">
                            <option value="small" <?php echo e(($content['options']['height'] ?? '') === 'small' ? 'selected' : ''); ?>>Petite (300px)</option>
                            <option value="medium" <?php echo e(($content['options']['height'] ?? 'medium') === 'medium' ? 'selected' : ''); ?>>Moyenne (500px)</option>
                            <option value="large" <?php echo e(($content['options']['height'] ?? '') === 'large' ? 'selected' : ''); ?>>Grande (700px)</option>
                            <option value="full" <?php echo e(($content['options']['height'] ?? '') === 'full' ? 'selected' : ''); ?>>Plein écran</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Slides -->
            <div class="slides-container builder-slider" data-component-id="<?php echo e($componentId); ?>">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <h6 class="fw-bold text-primary mb-0">
                        <i class="bi bi-collection"></i> Slides 
                        <span class="badge bg-primary slides-count"><?php echo e(count($content['slides'] ?? []) ?: 3); ?></span>
                    </h6>
                    <button type="button" class="btn btn-sm btn-primary add-slide">
                        <i class="bi bi-plus-circle"></i> Ajouter une slide
                    </button>
                </div>
                
                <div class="slides-list sortable-list">
                    <?php
                        $slides = $content['slides'] ?? [];
                        $slideCount = count($slides) ?: 3;
                    ?>
                    
                    <?php for($i = 0; $i < $slideCount; $i++): ?>
                    <div class="card mb-3 border-primary slide-item" data-index="<?php echo e($i); ?>">
                        <div class="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
                            <span class="fw-bold">
                                <i class="bi bi-grip-vertical handle cursor-move"></i> 
                                Slide #<span class="slide-number"><?php echo e($i + 1); ?></span>
                            </span>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-primary move-up" title="Monter">
                                    <i class="bi bi-arrow-up"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary move-down" title="Descendre">
                                    <i class="bi bi-arrow-down"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger remove-slide">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Image Upload -->
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-image"></i> Image de la slide *
                                    </label>
                                    <div class="image-preview-container mb-2 position-relative">
                                        <?php if(isset($content['slides'][$i]['image'])): ?>
                                            <img src="<?php echo e(Storage::url($content['slides'][$i]['image'])); ?>" 
                                                 class="img-thumbnail w-100" style="max-height: 200px; object-fit: cover;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-image">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        <?php else: ?>
                                            <div class="border rounded p-4 text-center text-muted bg-light">
                                                <i class="bi bi-cloud-upload" style="font-size: 3rem;"></i>
                                                <p class="mb-0 mt-2 small">Cliquez pour choisir une image</p>
                                                <small class="text-muted">Recommandé: 1920x1080px</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" name="content[slides][<?php echo e($i); ?>][image]" 
                                           class="form-control slide-image-input" accept="image/*">
                                    <input type="hidden" name="content[slides][<?php echo e($i); ?>][existing_image]" 
                                           value="<?php echo e($content['slides'][$i]['image'] ?? ''); ?>">
                                </div>

                                <!-- Content Fields -->
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-type-h1"></i> Titre principal
                                            </label>
                                            <input type="text" name="content[slides][<?php echo e($i); ?>][title]" 
                                                   class="form-control form-control-lg" 
                                                   value="<?php echo e($content['slides'][$i]['title'] ?? ''); ?>" 
                                                   placeholder="Ex: Nouvelle Collection Été 2024">
                                        </div>
                                        
                                        <div class="col-12">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-text-paragraph"></i> Sous-titre / Description
                                            </label>
                                            <textarea name="content[slides][<?php echo e($i); ?>][description]" 
                                                      class="form-control" rows="3" 
                                                      placeholder="Découvrez notre nouvelle collection avec jusqu'à -50% de réduction"><?php echo e($content['slides'][$i]['description'] ?? ''); ?></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-cursor"></i> Texte du bouton
                                            </label>
                                            <input type="text" name="content[slides][<?php echo e($i); ?>][button_text]" 
                                                   class="form-control" 
                                                   value="<?php echo e($content['slides'][$i]['button_text'] ?? ''); ?>" 
                                                   placeholder="Ex: Découvrir">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-link-45deg"></i> Lien du bouton
                                            </label>
                                            <input type="url" name="content[slides][<?php echo e($i); ?>][link]" 
                                                   class="form-control" 
                                                   value="<?php echo e($content['slides'][$i]['link'] ?? ''); ?>" 
                                                   placeholder="https://example.com/produits">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-palette"></i> Position du texte
                                            </label>
                                            <select name="content[slides][<?php echo e($i); ?>][text_position]" class="form-select">
                                                <option value="left" <?php echo e(($content['slides'][$i]['text_position'] ?? 'left') === 'left' ? 'selected' : ''); ?>>Gauche</option>
                                                <option value="center" <?php echo e(($content['slides'][$i]['text_position'] ?? '') === 'center' ? 'selected' : ''); ?>>Centre</option>
                                                <option value="right" <?php echo e(($content['slides'][$i]['text_position'] ?? '') === 'right' ? 'selected' : ''); ?>>Droite</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-circle-half"></i> Overlay (transparence)
                                            </label>
                                            <select name="content[slides][<?php echo e($i); ?>][overlay]" class="form-select">
                                                <option value="none" <?php echo e(($content['slides'][$i]['overlay'] ?? 'none') === 'none' ? 'selected' : ''); ?>>Aucun</option>
                                                <option value="light" <?php echo e(($content['slides'][$i]['overlay'] ?? '') === 'light' ? 'selected' : ''); ?>>Léger</option>
                                                <option value="medium" <?php echo e(($content['slides'][$i]['overlay'] ?? '') === 'medium' ? 'selected' : ''); ?>>Moyen</option>
                                                <option value="dark" <?php echo e(($content['slides'][$i]['overlay'] ?? '') === 'dark' ? 'selected' : ''); ?>>Sombre</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.cursor-move {
    cursor: move;
}

.slide-item {
    transition: all 0.3s ease;
}

.slide-item:hover {
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
}

.image-preview-container {
    position: relative;
    min-height: 120px;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
}

.sortable-ghost {
    opacity: 0.5;
    background: #f0f9ff;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
$(document).ready(function() {
    const root = $('.builder-slider[data-component-id="<?php echo e($componentId); ?>"]');
    if (!root.length) return;

    let slideIndex = root.find('.slide-item').length || 3;

    // Initialize Sortable for drag & drop
    const sortable = new Sortable(root.find('.slides-list')[0], {
        animation: 150,
        handle: '.handle',
        ghostClass: 'sortable-ghost',
        onEnd: function() {
            updateSlideNumbers();
        }
    });

    // Update slides count badge
    function updateSlidesCount() {
        const count = root.find('.slide-item').length;
        root.find('.slides-count').text(count);
    }

    // Add new slide
    root.on('click', '.add-slide', function() {
        const newSlide = `
            <div class="card mb-3 border-primary slide-item" data-index="${slideIndex}">
                <div class="card-header bg-primary bg-opacity-10 d-flex justify-content-between align-items-center">
                    <span class="fw-bold">
                        <i class="bi bi-grip-vertical handle cursor-move"></i> 
                        Slide #<span class="slide-number">${slideIndex + 1}</span>
                    </span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-primary move-up" title="Monter">
                            <i class="bi bi-arrow-up"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary move-down" title="Descendre">
                            <i class="bi bi-arrow-down"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger remove-slide">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold"><i class="bi bi-image"></i> Image de la slide *</label>
                            <div class="image-preview-container mb-2">
                                <div class="border rounded p-4 text-center text-muted bg-light">
                                    <i class="bi bi-cloud-upload" style="font-size: 3rem;"></i>
                                    <p class="mb-0 mt-2 small">Cliquez pour choisir une image</p>
                                    <small class="text-muted">Recommandé: 1920x1080px</small>
                                </div>
                            </div>
                            <input type="file" name="content[slides][${slideIndex}][image]" class="form-control slide-image-input" accept="image/*">
                        </div>
                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold"><i class="bi bi-type-h1"></i> Titre principal</label>
                                    <input type="text" name="content[slides][${slideIndex}][title]" class="form-control form-control-lg" placeholder="Ex: Nouvelle Collection">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold"><i class="bi bi-text-paragraph"></i> Description</label>
                                    <textarea name="content[slides][${slideIndex}][description]" class="form-control" rows="3" placeholder="Description de la slide"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"><i class="bi bi-cursor"></i> Texte du bouton</label>
                                    <input type="text" name="content[slides][${slideIndex}][button_text]" class="form-control" placeholder="Ex: Découvrir">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"><i class="bi bi-link-45deg"></i> Lien du bouton</label>
                                    <input type="url" name="content[slides][${slideIndex}][link]" class="form-control" placeholder="https://...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"><i class="bi bi-palette"></i> Position du texte</label>
                                    <select name="content[slides][${slideIndex}][text_position]" class="form-select">
                                        <option value="left" selected>Gauche</option>
                                        <option value="center">Centre</option>
                                        <option value="right">Droite</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"><i class="bi bi-circle-half"></i> Overlay</label>
                                    <select name="content[slides][${slideIndex}][overlay]" class="form-select">
                                        <option value="none" selected>Aucun</option>
                                        <option value="light">Léger</option>
                                        <option value="medium">Moyen</option>
                                        <option value="dark">Sombre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        root.find('.slides-list').append(newSlide);
        slideIndex++;
        updateSlideNumbers();
        updateSlidesCount();
    });
    
    // Remove slide
    root.on('click', '.remove-slide', function() {
        if (root.find('.slide-item').length > 1) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette slide ?')) {
                $(this).closest('.slide-item').fadeOut(300, function() {
                    $(this).remove();
                    updateSlideNumbers();
                    updateSlidesCount();
                });
            }
        } else {
            alert('Vous devez garder au moins une slide!');
        }
    });

    // Move slide up
    root.on('click', '.move-up', function() {
        const slide = $(this).closest('.slide-item');
        const prev = slide.prev('.slide-item');
        if (prev.length) {
            slide.insertBefore(prev);
            updateSlideNumbers();
        }
    });

    // Move slide down
    root.on('click', '.move-down', function() {
        const slide = $(this).closest('.slide-item');
        const next = slide.next('.slide-item');
        if (next.length) {
            slide.insertAfter(next);
            updateSlideNumbers();
        }
    });
    
    // Update slide numbers
    function updateSlideNumbers() {
        root.find('.slide-item').each(function(index) {
            $(this).attr('data-index', index);
            $(this).find('.slide-number').text(index + 1);
            
            // Update input names to maintain correct order
            $(this).find('input, textarea, select').each(function() {
                const name = $(this).attr('name');
                if (name && name.includes('[slides][')) {
                    const newName = name.replace(/\[slides\]\[\d+\]/, `[slides][${index}]`);
                    $(this).attr('name', newName);
                }
            });
        });
    }
    
    // Image preview on file select
    root.on('change', '.slide-image-input', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            const preview = $(this).siblings('.image-preview-container');
            
            // Validate file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('L\'image est trop volumineuse. Taille maximale: 5MB');
                $(this).val('');
                return;
            }
            
            reader.onload = function(e) {
                preview.html(`
                    <img src="${e.target.result}" class="img-thumbnail w-100" style="max-height: 200px; object-fit: cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 remove-image">
                        <i class="bi bi-x"></i>
                    </button>
                `);
            }
            reader.readAsDataURL(file);
        }
    });

    // Remove image
    root.on('click', '.remove-image', function() {
        const container = $(this).closest('.image-preview-container');
        const input = container.siblings('.slide-image-input');
        
        container.html(`
            <div class="border rounded p-4 text-center text-muted bg-light">
                <i class="bi bi-cloud-upload" style="font-size: 3rem;"></i>
                <p class="mb-0 mt-2 small">Cliquez pour choisir une image</p>
                <small class="text-muted">Recommandé: 1920x1080px</small>
            </div>
        `);
        input.val('');
    });

    // Initialize
    updateSlidesCount();
});
</script><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/dashboard/builder/partials/slider.blade.php ENDPATH**/ ?>