@extends('layouts.dashboard')

@section('title', 'Gestion des Utilisateurs -  Admin')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1">👥 Gestion des Utilisateurs</h2>
                            <p class="text-muted mb-0">Consulter, filtrer et gérer les utilisateurs de la plateforme</p>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-primary fs-6">Total: {{ $roleStats['total'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques par rôle -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Utilisateurs</h6>
                            <h3 class="mb-0 text-primary">{{ $roleStats['total'] }}</h3>
                        </div>
                        <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Super Admins</h6>
                            <h3 class="mb-0 text-danger">{{ $roleStats['super_admin'] }}</h3>
                        </div>
                        <i class="bi bi-shield-lock text-danger" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Marchands</h6>
                            <h3 class="mb-0 text-success">{{ $roleStats['merchant'] }}</h3>
                        </div>
                        <i class="bi bi-shop text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Clients</h6>
                            <h3 class="mb-0 text-info">{{ $roleStats['customer'] }}</h3>
                        </div>
                        <i class="bi bi-person-check text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('super-admin.users.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher (nom, email, téléphone)..." value="{{ $search }}">
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">Tous les rôles</option>
                        <option value="super_admin" {{ $role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="merchant" {{ $role === 'merchant' ? 'selected' : '' }}>Marchand</option>
                        <option value="customer" {{ $role === 'customer' ? 'selected' : '' }}>Client</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Chercher
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('super-admin.users.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-clockwise"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table des utilisateurs -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Rôle</th>
                        <th>Date d'inscription</th>
                        <th>Statut Email</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users  as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                        {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0"><strong>{{ $user->full_name }}</strong></h6>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                            <td>
                                
                                @if($user->role === 'owner')
                                    <span class="badge bg-success">Marchand</span>
                                @elseif($user->role === 'client')
                                    <span class="badge bg-info">Client</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $user->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Vérifié</span>
                                @else
                                    <span class="badge bg-warning"><i class="bi bi-clock"></i> En attente</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('super-admin.users.show', $user) }}" class="btn btn-outline-primary" title="Voir les détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}" title="Supprimer l'utilisateur">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de suppression -->
                        @if($user->id !== auth()->id())
                            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Confirmer la suppression</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0">Êtes-vous sûr de vouloir supprimer <strong>{{ $user->full_name }}</strong> ({{ $user->email }}) ?</p>
                                            <p class="text-danger small mt-2"><i class="bi bi-exclamation-triangle"></i> Cette action est irréversible.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <form method="POST" action="{{ route('super-admin.users.destroy', $user) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                                <p class="text-muted mt-2">Aucun utilisateur trouvé</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@push('styles')
<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .btn-group-sm .btn {
        padding: 0.375rem 0.75rem;
    }
</style>
@endpush
@endsection
