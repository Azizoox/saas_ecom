@extends('layouts.dashboard')

@section('title', 'Modifier le produit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-pencil"></i> Modifier le produit</h2>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="row">
    <div class="col-12">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Colonne gauche - Informations générales -->
                <div class="col-lg-8">
                    <!-- Informations générales du produit -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-info-circle"></i> Informations générales</h5>
                        </div>
                        <div class="card-body">
                          <input type="hidden" name="shop_id" value="{{ Auth::user()->shop->id }}">

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Catégorie</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                    <option value="">Aucune catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            data-shop-id="{{ $category->shop_id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                             {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Optionnel, mais recommandé pour organiser les produits.</small>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nom du produit <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sku" class="form-label">SKU (Code produit)</label>
                                        <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                                        @error('sku')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="reference" class="form-label">Référence</label>
                                        <input type="text" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ old('reference', $product->reference) }}">
                                        @error('reference')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="barcode" class="form-label">Code à barre (EAN/UPC)</label>
                                        <input type="text" class="form-control @error('barcode') is-invalid @enderror" id="barcode" name="barcode" value="{{ old('barcode', $product->barcode) }}">
                                        @error('barcode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="supplier" class="form-label">Fournisseur principal</label>
                                        <input type="text" class="form-control @error('supplier') is-invalid @enderror" id="supplier" name="supplier" value="{{ old('supplier', $product->supplier) }}" list="suppliers">
                                        <datalist id="suppliers">
                                            <option value="Fournisseur A">
                                            <option value="Fournisseur B">
                                            <option value="Fournisseur C">
                                        </datalist>
                                        @error('supplier')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="brand" class="form-label">Marque</label>
                                        <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand', $product->brand) }}" list="brands">
                                        <datalist id="brands">
                                            <option value="Marque A">
                                            <option value="Marque B">
                                            <option value="Marque C">
                                        </datalist>
                                        @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Descriptions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-card-text"></i> Descriptions</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="short_description" class="form-label">Description courte</label>
                                <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" rows="3" maxlength="500">{{ old('short_description', $product->short_description) }}</textarea>
                                <small class="form-text text-muted">Résumé rapide du produit (avantages clés, 1-2 phrases)</small>
                                @error('short_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description longue</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6">{{ old('description', $product->description) }}</textarea>
                                <small class="form-text text-muted">Description détaillée (caractéristiques, usage, bénéfices)</small>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Images du produit -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-images"></i> Images du produit</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="image" class="form-label">Image principale</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                @if($product->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Image actuelle" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                                <small class="form-text text-muted">Image principale du produit (formats: JPG, PNG, WEBP)</small>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Galerie d'images</label>
                                <div class="dropzone border rounded p-4 text-center" id="imageGallery">
                                    <i class="bi bi-cloud-arrow-up" style="font-size: 2rem; color: #6c757d;"></i>
                                    <p class="mb-2">Glissez-déposez des images ici</p>
                                    <p class="text-muted small">ou cliquez pour sélectionner</p>
                                    <input type="file" class="d-none" id="galleryInput" name="gallery[]" multiple accept="image/*">
                                </div>
                                <div class="mt-3" id="galleryPreview">
                                    @if($product->images)
                                        @foreach(json_decode($product->images) as $img)
                                            <img src="{{ asset('storage/' . $img) }}" class="img-thumbnail me-2 mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Variantes & Combinaisons -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-grid-3x3-gap"></i> Variantes & Combinaisons</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Attributs de variante</label>
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <select class="form-select" id="variantAttribute">
                                            <option value="">Sélectionner un attribut</option>
                                            <option value="taille">Taille</option>
                                            <option value="couleur">Couleur</option>
                                            <option value="matiere">Matière</option>
                                            <option value="poids">Poids</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="variantValue" placeholder="Valeur (ex: S, M, L ou Rouge, Bleu)">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-primary w-100" id="addVariantBtn">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="variantsList" class="mt-3">
                                    @if($product->variants)
                                        @foreach(json_decode($product->variants) as $variant)
                                            <div class="alert alert-secondary d-flex justify-content-between align-items-center mb-2">
                                                <span>{{ $variant->attribute }}: {{ $variant->value }}</span>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariant({{ $loop->index }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Groupe de produits -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-collection"></i> Groupe de produits</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="product_group_id" class="form-label">Groupe de produits</label>
                                <select class="form-select @error('product_group_id') is-invalid @enderror" id="product_group_id" name="product_group_id">
                                    <option value="">Aucun groupe</option>
                                    <!-- Options will be populated dynamically -->
                                    @if($product->productGroup)
                                        <option value="{{ $product->productGroup->id }}" selected>{{ $product->productGroup->name }}</option>
                                    @endif
                                </select>
                                <small class="form-text text-muted">Lier ce produit à un groupe existant</small>
                                @error('product_group_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne droite - SEO et paramètres -->
                <div class="col-lg-4">
                    <!-- Référencement naturel (SEO) -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-search"></i> SEO</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Titre meta</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" maxlength="255">
                                <small class="form-text text-muted">Titre optimisé pour les moteurs de recherche</small>
                                @error('meta_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Description meta</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3" maxlength="160">{{ old('meta_description', $product->meta_description) }}</textarea>
                                <small class="form-text text-muted">Description courte et optimisée SEO</small>
                                @error('meta_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Mots-clés</label>
                                <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $product->meta_keywords) }}">
                                <small class="form-text text-muted">Mots-clés séparés par des virgules</small>
                                @error('meta_keywords')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Paramètres du produit -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-gear"></i> Paramètres</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Prix (TND) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                        <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                                        @error('stock')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Produit actif (visible dans la boutique)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Annuler
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Enregistrer les modifications
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la galerie d'images
    const dropzone = document.getElementById('imageGallery');
    const galleryInput = document.getElementById('galleryInput');
    const galleryPreview = document.getElementById('galleryPreview');
    
    // Clic sur la zone de drop
    dropzone.addEventListener('click', () => {
        galleryInput.click();
    });
    
    // Glisser-déposer
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('bg-light');
    });
    
    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('bg-light');
    });
    
    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('bg-light');
        
        const files = e.dataTransfer.files;
        if (files.length) {
            galleryInput.files = files;
            previewImages(files);
        }
    });
    
    // Sélection via input
    galleryInput.addEventListener('change', () => {
        previewImages(galleryInput.files);
    });
    
    function previewImages(files) {
        galleryPreview.innerHTML = '';
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail me-2 mb-2';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    galleryPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    }
    
    // Gestion des variantes
    const addVariantBtn = document.getElementById('addVariantBtn');
    const variantsList = document.getElementById('variantsList');
    let variants = @json($product->variants ? json_decode($product->variants) : []);
    
    addVariantBtn.addEventListener('click', () => {
        const attribute = document.getElementById('variantAttribute').value;
        const value = document.getElementById('variantValue').value;
        
        if (attribute && value) {
            variants.push({ attribute, value });
            updateVariantsList();
            document.getElementById('variantValue').value = '';
        }
    });
    
    function updateVariantsList() {
        variantsList.innerHTML = '';
        variants.forEach((variant, index) => {
            const div = document.createElement('div');
            div.className = 'alert alert-secondary d-flex justify-content-between align-items-center mb-2';
            div.innerHTML = `
                <span>${variant.attribute}: ${variant.value}</span>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariant(${index})">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            variantsList.appendChild(div);
        });
        
        // Mettre à jour le champ caché
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'variants';
        hiddenInput.value = JSON.stringify(variants);
        document.querySelector('form').appendChild(hiddenInput);
    }
    
    window.removeVariant = function(index) {
        variants.splice(index, 1);
        updateVariantsList();
    };
});
</script>
@endpush
@endsection