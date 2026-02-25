@extends('layouts.dashboard')

@section('title', 'Gestion des produits')

@push('styles')
<style>
    .delete-modal-content { border-radius: 16px; overflow: hidden; }
    .delete-modal-icon-wrap {
        width: 56px; height: 56px; border-radius: 50%;
        background: rgba(239, 68, 68, 0.12); color: #ef4444;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; margin: 0 auto;
    }
    .delete-modal-content .modal-title { font-weight: 700; font-size: 1.1rem; }
    .delete-modal-content .btn-delete-confirm { border-radius: 10px; font-weight: 600; padding: 0.6rem 1rem; }
    .delete-modal-content .btn-outline-secondary { border-radius: 10px; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-seam"></i> Mes produits</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Ajouter un produit
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Boutique</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 4px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->sku)
                                    <br><small class="text-muted">SKU: {{ $product->sku }}</small>
                                @endif
                            </td>
                            <td>{{ $product->shop->name }}</td>
                            <td>{{ $product->formatted_price }}</td>
                            <td>
                                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                    {{ $product->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline delete-product-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-trigger-delete" title="Supprimer"
                                                data-delete-title="Supprimer ce produit ?"
                                                data-delete-message="« {{ e($product->name) }} » sera définitivement supprimé. Cette action est irréversible.">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-box-seam" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun produit pour le moment.</p>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Ajouter votre premier produit
                </a>
            </div>
        @endif
    </div>
</div>

{{-- Modal: Delete product confirmation (pro) --}}
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
@endsection

@push('scripts')
<script>
(function() {
    var deleteModal = document.getElementById('deleteConfirmModal');
    var deleteModalTitle = deleteModal ? deleteModal.querySelector('#deleteConfirmModalLabel') : null;
    var deleteModalMessage = deleteModal ? deleteModal.querySelector('.delete-modal-message') : null;
    var deleteConfirmBtn = deleteModal ? deleteModal.querySelector('.btn-delete-confirm') : null;
    var formToSubmit = null;

    if (deleteModal && deleteConfirmBtn) {
        document.querySelectorAll('.btn-trigger-delete').forEach(function(btn) {
            btn.addEventListener('click', function() {
                formToSubmit = this.closest('form');
                if (deleteModalTitle) deleteModalTitle.textContent = this.getAttribute('data-delete-title') || 'Supprimer ?';
                if (deleteModalMessage) deleteModalMessage.textContent = this.getAttribute('data-delete-message') || 'Cette action est irréversible.';
                (new bootstrap.Modal(deleteModal)).show();
            });
        });
        deleteConfirmBtn.addEventListener('click', function() {
            if (formToSubmit) formToSubmit.submit();
            bootstrap.Modal.getInstance(deleteModal).hide();
            formToSubmit = null;
        });
        deleteModal.addEventListener('hidden.bs.modal', function() { formToSubmit = null; });
    }
})();
</script>
@endpush
