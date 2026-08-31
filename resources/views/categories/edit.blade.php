@extends('layouts.dashboard')

@section('title', 'Modifier la catégorie')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Succès!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <strong>Erreur!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Modifier la catégorie</h1>
                <div>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                    </a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal" title="Supprimer cette catégorie">
                        <i class="bi bi-trash me-2"></i>Supprimer
                    </button>
                </div>
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
                                           id="name" name="name" value="{{ old('name', $category->name) }}" required autocomplete="off">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="shop_id" class="form-label">Boutique *</label>
                                    <select class="form-select @error('shop_id') is-invalid @enderror" 
                                            id="shop_id" name="shop_id" required autocomplete="off">
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
                                            @if($cat->id !== $category->id)
                                                <option value="{{ $cat->id }}" {{ (old('parent_id', $category->parent_id) == $cat->id) ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Une catégorie ne peut pas être sa propre parente</small>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Ordre d'affichage</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                           id="order" name="order" value="{{ old('order', $category->order) }}" min="0" autocomplete="off">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" autocomplete="off">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="icon" class="form-label">Icône (2MB max)</label>
                                    <input type="file" class="form-control @error('icon') is-invalid @enderror" 
                                           id="icon" name="icon" accept="image/*" autocomplete="off">
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
                                           id="image" name="image" accept="image/*" autocomplete="off">
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
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Catégorie active
                            </label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="bi bi-save me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Category Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteCategoryModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Êtes-vous sûr de vouloir supprimer la catégorie <strong>"{{ $category->name }}"</strong> ?</p>
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <strong>Attention:</strong> Cette action est irréversible. Les sous-catégories ne seront pas supprimées mais seront déliées de cette catégorie.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="{{ route('categories.destroy', $category) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="deleteConfirmBtn">
                        <i class="bi bi-trash me-2"></i>Supprimer définitivement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');
    const deleteConfirmBtn = document.getElementById('deleteConfirmBtn');
    const alertElements = document.querySelectorAll('.alert');
    
    // Auto-dismiss alerts after 5 seconds
    alertElements.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Prevent self-selection as parent
    document.getElementById('parent_id').addEventListener('change', function() {
        if (this.value === '{{ $category->id }}') {
            alert('Une catégorie ne peut pas être sa propre parente.');
            this.value = '';
        }
    });

    // Form submission with loading state
    if (form) {
        form.addEventListener('submit', function(e) {
            // Basic client-side validation
            const nameInput = document.getElementById('name');
            if (!nameInput.value.trim()) {
                e.preventDefault();
                alert('Le nom de la catégorie est requis.');
                nameInput.focus();
                return false;
            }

            // Show loading state
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalHTML = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mise à jour en cours...';
                
                // Restore button if form submission fails
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHTML;
                    }
                }, 5000);
            }
        });
    }

    // Delete button loading state
    if (deleteConfirmBtn) {
        deleteConfirmBtn.addEventListener('click', function(e) {
            this.disabled = true;
            const originalHTML = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Suppression en cours...';
        });
    }

    // Preview uploaded images with validation
    function previewImage(inputId, previewId, maxSizeMB = 5) {
        document.getElementById(inputId).addEventListener('change', function(e) {
            const input = this;
            const maxSize = maxSizeMB * 1024 * 1024;
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file size
                if (file.size > maxSize) {
                    alert(`Le fichier est trop volumineux (max ${maxSizeMB}MB).`);
                    input.value = '';
                    return;
                }
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Veuillez sélectionner un fichier image valide.');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    let preview = document.getElementById(previewId);
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.id = previewId;
                        preview.className = 'mt-2 rounded';
                        preview.style.maxWidth = '200px';
                        preview.style.maxHeight = '200px';
                        input.parentNode.appendChild(preview);
                    }
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Initialize image previews
    previewImage('icon', 'icon-preview', 2);
    previewImage('image', 'image-preview', 5);

    // Prevent double submission
    let isSubmitting = false;
    if (form) {
        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            isSubmitting = true;
        });
    }
});
</script>
@endsection