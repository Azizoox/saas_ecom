<div class="row mb-4">
    <div class="col-md-6">
        <label class="form-label fw-bold"><i class="bi bi-chat-quote"></i> Titre du composant</label>
        <input type="text" name="content[title]" class="form-control" value="{{ $content['title'] ?? 'Ce que disent nos clients' }}" placeholder="Titre de la section">
    </div>
    <div class="col-md-6">
        <label class="form-label fw-bold"><i class="bi bi-layout-three-columns"></i> Style d'affichage</label>
        <select name="content[style]" class="form-select">
            <option value="slider" {{ ($content['style'] ?? '') === 'slider' ? 'selected' : '' }}>Slider</option>
            <option value="grid" {{ ($content['style'] ?? '') === 'grid' ? 'selected' : '' }}>Grille</option>
        </select>
    </div>
</div>

<div class="reviews-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold text-primary mb-0"><i class="bi bi-star"></i> Avis Clients</h6>
        <button type="button" class="btn btn-sm btn-outline-primary add-review">
            <i class="bi bi-plus-circle"></i> Ajouter un avis
        </button>
    </div>
    
    <div class="reviews-list">
        @for($i = 0; $i < 3; $i++)
        <div class="card mb-3 border-warning review-item" data-index="{{ $i }}">
            <div class="card-header bg-warning bg-opacity-10 d-flex justify-content-between align-items-center">
                <span class="fw-bold"><i class="bi bi-grip-vertical handle"></i> Avis #{{ $i + 1 }}</span>
                <button type="button" class="btn btn-sm btn-danger remove-review">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nom du client</label>
                        <input type="text" name="content[reviews][{{ $i }}][name]" class="form-control" placeholder="Ex: Marie Dupont" value="{{ $content['reviews'][$i]['name'] ?? '' }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Note</label>
                        <select name="content[reviews][{{ $i }}][rating]" class="form-select rating-select">
                            @for($r = 5; $r >= 1; $r--)
                                <option value="{{ $r }}" {{ ($content['reviews'][$i]['rating'] ?? 5) == $r ? 'selected' : '' }}>
                                    @for($s = 0; $s < $r; $s++)⭐@endfor
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Commentaire</label>
                        <textarea name="content[reviews][{{ $i }}][text]" class="form-control" rows="2" placeholder="Excellent service, produits de qualité...">{{ $content['reviews'][$i]['text'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>

<script>
$(document).ready(function() {
    const root = $('.reviews-section').has('.add-review').last();
    if (!root.length) return;

    let reviewIndex = root.find('.review-item').length || 3;
    
    // Add new review
    root.on('click', '.add-review', function() {
        const newReview = `
            <div class="card mb-3 border-warning review-item" data-index="${reviewIndex}">
                <div class="card-header bg-warning bg-opacity-10 d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="bi bi-grip-vertical handle"></i> Avis #${reviewIndex + 1}</span>
                    <button type="button" class="btn btn-sm btn-danger remove-review">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Nom du client</label>
                            <input type="text" name="content[reviews][${reviewIndex}][name]" class="form-control" placeholder="Ex: Marie Dupont">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-bold">Note</label>
                            <select name="content[reviews][${reviewIndex}][rating]" class="form-select">
                                <option value="5" selected>⭐⭐⭐⭐⭐</option>
                                <option value="4">⭐⭐⭐⭐</option>
                                <option value="3">⭐⭐⭐</option>
                                <option value="2">⭐⭐</option>
                                <option value="1">⭐</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Commentaire</label>
                            <textarea name="content[reviews][${reviewIndex}][text]" class="form-control" rows="2" placeholder="Excellent service..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        `;
        root.find('.reviews-list').append(newReview);
        reviewIndex++;
    });
    
    // Remove review
    root.on('click', '.remove-review', function() {
        if (root.find('.review-item').length > 1) {
            $(this).closest('.review-item').fadeOut(300, function() {
                $(this).remove();
                updateReviewNumbers();
            });
        } else {
            alert('Vous devez garder au moins un avis!');
        }
    });
    
    // Update review numbers
    function updateReviewNumbers() {
        root.find('.review-item').each(function(index) {
            $(this).find('.card-header span').html(`<i class="bi bi-grip-vertical handle"></i> Avis #${index + 1}`);
        });
    }
});
</script>
