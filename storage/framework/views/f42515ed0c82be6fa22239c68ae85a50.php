<div class="card border-info mb-3">
    <div class="card-header bg-info bg-opacity-10">
        <h6 class="fw-bold text-info mb-0"><i class="bi bi-megaphone"></i> Configuration du Bandeau</h6>
    </div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-fonts"></i> Texte principal</label>
                <input type="text" name="content[text_main]" class="form-control" value="<?php echo e($content['text_main'] ?? ''); ?>" placeholder="Ex: PROMO -50% sur toute la collection !">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold"><i class="bi bi-chat-left-text"></i> Texte secondaire</label>
                <input type="text" name="content[text_secondary]" class="form-control" value="<?php echo e($content['text_secondary'] ?? ''); ?>" placeholder="Ex: Livraison gratuite dès 50€">
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold"><i class="bi bi-speedometer"></i> Vitesse de défilement (sec)</label>
                <input type="number" name="content[speed]" class="form-control" value="<?php echo e($content['speed'] ?? 10); ?>" min="5" max="30" step="1">
                <small class="text-muted">Durée pour un cycle complet</small>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold"><i class="bi bi-palette"></i> Couleur de fond</label>
                <div class="input-group">
                    <input type="color" name="content[bg_color]" class="form-control form-control-color banner-color" value="<?php echo e($content['bg_color'] ?? '#000000'); ?>" id="bannerColor-<?php echo e($componentId); ?>">
                    <input type="text" class="form-control banner-color-hex" id="bannerColorHex-<?php echo e($componentId); ?>" value="<?php echo e($content['bg_color'] ?? '#000000'); ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold"><i class="bi bi-link-45deg"></i> Lien (optionnel)</label>
                <input type="url" name="content[link]" class="form-control" value="<?php echo e($content['link'] ?? ''); ?>" placeholder="https://...">
                <small class="text-muted">Le bandeau sera cliquable</small>
            </div>
        </div>
        
        <!-- Preview -->
        <div class="mt-4">
            <label class="form-label fw-bold"><i class="bi bi-eye"></i> Aperçu</label>
            <div class="border rounded p-3 text-white text-center banner-preview" style="background-color: <?php echo e($content['bg_color'] ?? '#000000'); ?>; overflow: hidden;">
                <div class="d-inline-block">
                    <span class="fw-bold me-3 preview-main"><?php echo e($content['text_main'] ?? 'Texte principal'); ?></span>
                    <span class="opacity-75 preview-secondary"><?php echo e($content['text_secondary'] ?? 'Texte secondaire'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const root = $('#bannerColor-<?php echo e($componentId); ?>').closest('.card');
    if (!root.length) return;

    // Live preview updates
    root.on('input', 'input[name="content[text_main]"]', function() {
        root.find('.preview-main').text($(this).val() || 'Texte principal');
    });
    
    root.on('input', 'input[name="content[text_secondary]"]', function() {
        root.find('.preview-secondary').text($(this).val() || 'Texte secondaire');
    });
    
    root.on('change', 'input.banner-color', function() {
        const color = $(this).val();
        root.find('.banner-preview').css('background-color', color);
        root.find('.banner-color-hex').val(color);
    });
});
</script>
<?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/dashboard/builder/partials/banner.blade.php ENDPATH**/ ?>