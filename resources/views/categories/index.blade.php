@extends('layouts.dashboard')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Catégories</h1>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Ajouter une catégorie
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des catégories</h6>
                </div>
                <div class="card-body">
                    @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="categoriesTable">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Boutique</th>
                                        <th>Parent</th>
                                        <th>Ordre</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($category->icon)
                                                        <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" class="me-2" style="width: 30px; height: 30px; object-fit: contain;">
                                                    @endif
                                                    <div>
                                                        <strong>{{ $category->name }}</strong>
                                                        @if($category->description)
                                                            <br><small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $category->shop->name ?? 'N/A' }}</td>
                                            <td>{{ $category->parent->name ?? '-' }}</td>
                                            <td>{{ $category->order }}</td>
                                            <td>
                                                <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                                    {{ $category->is_active ? 'Actif' : 'Inactif' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('categories.show', $category) }}" class="btn btn-info btn-sm" title="Voir">
                                                        <i class="fas fa-eye">Voir</i>
                                                    </a>
                                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm" title="Modifier">
                                                        <i class="fas fa-edit">Modifier</i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')" 
                                                            title="Supprimer">
                                                        <i class="fas fa-trash">Supprimer</i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Aucune catégorie trouvée</h4>
                            <p class="text-muted">Commencez par créer votre première catégorie.</p>
                            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Créer une catégorie
                            </a>
                        </div>
                    @endif
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

// Initialize DataTable
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $('#categoriesTable').DataTable !== 'undefined') {
        $('#categoriesTable').DataTable({
            "order": [[ 3, "asc" ]], // Order by order column
            "pageLength": 25,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
            }
        });
    }
});
</script>
@endsection