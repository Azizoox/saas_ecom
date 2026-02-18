@extends('layouts.dashboard')

@section('title', 'Détails de la catégorie')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Détails de la catégorie</h1>
                <div>
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-2"></i>Modifier
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informations générales</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-primary">Nom:</h6>
                                    <p>{{ $category->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-primary">Slug:</h6>
                                    <p>{{ $category->slug }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-primary">Boutique:</h6>
                                    <p>{{ $category->shop->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-primary">Parent:</h6>
                                    <p>{{ $category->parent->name ?? 'Aucun (catégorie racine)' }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-primary">Ordre:</h6>
                                    <p>{{ $category->order }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-primary">Statut:</h6>
                                    <p>
                                        <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                            {{ $category->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            @if($category->description)
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="font-weight-bold text-primary">Description:</h6>
                                        <p>{{ $category->description }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-primary">Date de création:</h6>
                                    <p>{{ $category->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="font-weight-bold text-primary">Dernière modification:</h6>
                                    <p>{{ $category->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Hiérarchie</h6>
                        </div>
                        <div class="card-body">
                            <h6 class="font-weight-bold text-primary">Arborescence:</h6>
                            <ol class="breadcrumb">
                                @foreach($category->breadcrumb() as $breadcrumb)
                                    <li class="breadcrumb-item {{ $breadcrumb->id == $category->id ? 'active' : '' }}">
                                        @if($breadcrumb->id == $category->id)
                                            {{ $breadcrumb->name }}
                                        @else
                                            <a href="{{ route('categories.show', $breadcrumb) }}">{{ $breadcrumb->name }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                            
                            @if($category->hasChildren())
                                <h6 class="font-weight-bold text-primary mt-3">Sous-catégories ({{ $category->children->count() }}):</h6>
                                <ul class="list-group">
                                    @foreach($category->children as $child)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                @if($child->icon)
                                                    <img src="{{ Storage::url($child->icon) }}" alt="{{ $child->name }}" style="width: 20px; height: 20px; object-fit: contain;" class="me-2">
                                                @endif
                                                {{ $child->name }}
                                            </span>
                                            <a href="{{ route('categories.show', $child) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Cette catégorie n'a pas de sous-catégories.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Médias</h6>
                        </div>
                        <div class="card-body text-center">
                            @if($category->icon)
                                <div class="mb-3">
                                    <h6 class="font-weight-bold text-primary">Icône:</h6>
                                    <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" class="img-fluid" style="max-height: 100px;">
                                </div>
                            @else
                                <p class="text-muted">Aucune icône</p>
                            @endif
                            
                            @if($category->image)
                                <div>
                                    <h6 class="font-weight-bold text-primary">Image:</h6>
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="img-fluid" style="max-height: 200px;">
                                </div>
                            @else
                                <p class="text-muted">Aucune image</p>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Statistiques</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Produits dans cette catégorie:</span>
                                @if($category->products)
                                <span class="badge bg-primary">{{ $category->products->count() }}</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>Sous-catégories directes:</span>
                                <span class="badge bg-info">{{ $category->children->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Niveau dans l'arborescence:</span>
                                <span class="badge bg-secondary">{{ $category->breadcrumb()->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Actions rapides</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('categories.create') }}?parent_id={{ $category->id }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Ajouter une sous-catégorie
                                </a>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Modifier
                                </a>
                                <button type="button" class="btn btn-danger" 
                                        onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')">
                                    <i class="fas fa-trash me-2"></i>Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la catégorie "<strong id="categoryName"></strong>" ?</p>
                <p class="text-danger"><small>Cette action est irréversible.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(categoryId, categoryName) {
    document.getElementById('categoryName').textContent = categoryName;
    document.getElementById('deleteForm').action = `/categories/${categoryId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endsection