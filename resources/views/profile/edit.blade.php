@extends('layouts.dashboard')

@section('title', 'Modifier mon profil')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1">👤 Modifier mes informations</h2>
                            <p class="text-muted mb-0">Mettez à jour vos données personnelles</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Informations personnelles -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">📋 Informations Personnelles</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Avatar -->
                        <div class="mb-4">
                            <label for="avatar" class="form-label">Photo de profil</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <div class="text-center">
                                            <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: bold; margin: 0 auto; position: relative;" id="avatarPreview">
                                                {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" 
                                           id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(event)">
                                    <small class="text-muted d-block mt-2">
                                        <i class="bi bi-info-circle"></i> Format: JPEG, PNG, JPG, GIF (Max 2MB)
                                    </small>
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Enregistrer les modifications
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Informations supplémentaires -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">ℹ️ Informations du compte</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Rôle</small>
                        <p class="fw-bold mb-0">
                            @if($user->role === 'super_admin')
                                <span class="badge bg-danger">Super Admin</span>
                            @elseif($user->role === 'merchant')
                                <span class="badge bg-success">Marchand</span>
                            @else
                                <span class="badge bg-info">Client</span>
                            @endif
                        </p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Statut Email</small>
                        <p class="fw-bold mb-0">
                            @if($user->email_verified_at)
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Vérifié</span>
                            @else
                                <span class="badge bg-warning"><i class="bi bi-clock"></i> Non vérifié</span>
                            @endif
                        </p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted">ID Utilisateur</small>
                        <p class="fw-bold text-monospace">{{ $user->id }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Inscrit depuis</small>
                        <p class="fw-bold">{{ $user->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted">Dernière modification</small>
                        <p class="fw-bold">{{ $user->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Sécurité -->
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">🔒 Sécurité</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Gérez vos paramètres de sécurité</p>
                    <button type="button" class="btn btn-outline-warning w-100" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="bi bi-key me-2"></i>Changer le mot de passe
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Changement de mot de passe -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">🔐 Changer le mot de passe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Ancien mot de passe</label>
                        <input type="password" class="form-control" id="oldPassword" name="old_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="changePasswordForm" class="btn btn-warning">
                    <i class="bi bi-check-circle me-2"></i>Mettre à jour
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">';
        };
        reader.readAsDataURL(file);
    }
}

// Change password form submission
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Implémenter la logique de changement de mot de passe
    alert('Fonctionnalité de changement de mot de passe à implémenter');
});
</script>
@endpush
@endsection
