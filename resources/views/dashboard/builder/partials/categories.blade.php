<div class="card border-0">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Titre du composant</label>
                <input type="text" name="content[title]" class="form-control" 
                       value="{{ $content['title'] ?? 'Nos Catégories' }}" 
                       placeholder="Ex: Nos Catégories, Découvrez nos collections...">
                <div class="form-text">Le titre qui s'affichera au-dessus des catégories</div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Style d'affichage</label>
                <select name="content[style]" class="form-select">
                    <option value="grid" {{ ($content['style'] ?? 'grid') === 'grid' ? 'selected' : '' }}>
                        Grille (statique)
                    </option>
                    <option value="slider" {{ ($content['style'] ?? 'grid') === 'slider' ? 'selected' : '' }}>
                        Slider (défilant)
                    </option>
                </select>
                <div class="form-text">Choisissez comment afficher vos catégories</div>
            </div>
        </div>
        
        <div class="mt-4">
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Note:</strong> Les catégories sont automatiquement récupérées depuis vos produits.
                Pour ajouter une catégorie, créez simplement un produit avec cette catégorie.
            </div>
        </div>
    </div>
</div>
