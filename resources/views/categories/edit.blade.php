@extends('layouts.dashboard')

@section('title', 'Modifier la catégorie')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Modifier la catégorie</h1>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                </a>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations de la catégorie</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom de la catégorie *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shop_id" class="form-label">Boutique *</label>
                                    <select class="form-select @error('shop_id') is-invalid @enderror" 
                                            id="shop_id" name="shop_id" required>
                                        <option value="">Sélectionnez une boutique</option>
                                        @foreach($shops as $shop)
                                            <option value="{{ $shop->id }}" {{ (old('shop_id', $category->shop_id) == $shop->id) ? 'selected' : '' }}>
                                                {{ $shop->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shop_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="parent_id" class="form-label">Catégorie parente</label>
                                    <select class="form-select @error('parent_id') is-invalid @enderror" 
                                            id="parent_id" name="parent_id">
                                        <option value="">Aucune (catégorie racine)</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ (old('parent_id', $category->parent_id) == $cat->id) ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Ordre d'affichage</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                           id="order" name="order" value="{{ old('order', $category->order) }}" min="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="icon" class="form-label">Icône (2MB max)</label>
                                    <input type="file" class="form-control @error('icon') is-invalid @enderror" 
                                           id="icon" name="icon" accept="image/*">
                                    <div class="form-text">Formats acceptés: JPG, PNG, SVG, GIF</div>
                                    @if($category->icon)
                                        <div class="mt-2">
                                            <small class="text-muted">Icône actuelle:</small>
                                            <br>
                                            <img src="{{ Storage::url($category->icon) }}" alt="Current icon" style="max-width: 100px; max-height: 100px;">
                                        </div>
                                    @endif
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image (5MB max)</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*">
                                    <div class="form-text">Formats acceptés: JPG, PNG, SVG, GIF</div>
                                    @if($category->image)
                                        <div class="mt-2">
                                            <small class="text-muted">Image actuelle:</small>
                                            <br>
                                            <img src="{{ Storage::url($category->image) }}" alt="Current image" style="max-width: 150px; max-height: 150px;">
                                        </div>
                                    @endif
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Catégorie active
                            </label>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary me-2">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    // Slug will be auto-generated by the model
});

// Preview uploaded images
document.getElementById('icon').addEventListener('change', function(e) {
    previewImage(e.target, 'icon-preview');
});

document.getElementById('image').addEventListener('change', function(e) {
    previewImage(e.target, 'image-preview');
});

function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.getElementById(previewId);
            if (!preview) {
                preview = document.createElement('img');
                preview.id = previewId;
                preview.className = 'mt-2';
                preview.style.maxWidth = '200px';
                preview.style.maxHeight = '200px';
                input.parentNode.appendChild(preview);
            }
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection