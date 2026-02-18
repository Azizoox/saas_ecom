@extends('layouts.dashboard')

@section('title', 'Constructeur de Page d\'Accueil')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-plus-circle me-2"></i>
                    <h5 class="mb-0">Ajouter un composant</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#addComponentModal" data-type="slider">
                            <i class="bi bi-images text-primary me-2"></i>
                            Slider / Carousel
                            <small class="text-muted d-block">Diaporama d'images</small>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#addComponentModal" data-type="categories">
                            <i class="bi bi-grid-3x3-gap text-success me-2"></i>
                            Catégories
                            <small class="text-muted d-block">Afficher les catégories</small>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#addComponentModal" data-type="premium_categories">
                            <i class="bi bi-star-fill text-warning me-2"></i>
                            Catégories Premium
                            <small class="text-muted d-block">Mise en avant spéciale</small>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#addComponentModal" data-type="banner">
                            <i class="bi bi-megaphone text-info me-2"></i>
                            Bandeau défilant
                            <small class="text-muted d-block">Annonce animée</small>
                        </button>
                        <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#addComponentModal" data-type="reviews">
                            <i class="bi bi-chat-quote text-secondary me-2"></i>
                            Avis Clients
                            <small class="text-muted d-block">Témoignages</small>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 bg-light">
                <div class="card-body p-3">
                    <h6 class="mb-2"><i class="bi bi-info-circle text-primary me-1"></i> Instructions</h6>
                    <ul class="small mb-0 ps-3">
                        <li>Cliquez sur un composant pour l'ajouter</li>
                        <li>Glissez-déposez pour réorganiser</li>
                        <li>Cliquez sur "Configurer" pour modifier</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0"><i class="bi bi-layout-text-sidebar-reverse me-2"></i> Page d'accueil</h4>
                    <div class="text-muted small">
                        <i class="bi bi-grip-vertical me-1"></i> Glissez pour réorganiser
                    </div>
                </div>
                @if(isset($shops) && $shops->count() > 1)
                    <form method="GET" action="{{ route('builder.index') }}" class="d-flex align-items-center gap-2">
                        <label class="small text-muted mb-0">Boutique</label>
                        <select name="shop_id" id="activeShopId" class="form-select form-select-sm" onchange="this.form.submit()">
                            @foreach($shops as $s)
                                <option value="{{ $s->id }}" @selected($shop->id === $s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </form>
                @else
                    <input type="hidden" id="activeShopId" value="{{ $shop->id }}">
                @endif
            </div>

            @if($components->isEmpty())
                <div class="text-center py-5 bg-light rounded border border-dashed">
                    <i class="bi bi-layout-text-sidebar-reverse display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">Page d'accueil vide</h5>
                    <p class="text-muted">Ajoutez des composants depuis le menu à gauche pour commencer.</p>
                </div>
            @else
                <div id="components-list" class="sortable-container">
                    @foreach($components as $component)
                        <div class="card shadow-sm mb-3 component-item" data-id="{{ $component->id }}">
                            <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-grip-vertical handle cursor-pointer text-muted me-3"></i>
                                    <div>
                                        <span class="fw-bold text-uppercase small">{{ $component->type }}</span>
                                        @if(!$component->is_active)
                                            <span class="badge bg-secondary ms-2">Inactif</span>
                                        @endif
                                        <div class="small text-muted">
                                            @switch($component->type)
                                                @case('slider')
                                                    {{ count($component->content['slides'] ?? []) }} slide(s)
                                                    @break
                                                @case('categories')
                                                    Style: {{ $component->content['style'] ?? 'grid' }}
                                                    @break
                                                @case('reviews')
                                                    {{ count($component->content['reviews'] ?? []) }} avis
                                                    @break
                                                @default
                                                    Configuré
                                            @endswitch
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <form action="{{ route('builder.destroy', $component) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce composant ?')">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="component-form-wrapper mt-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body bg-light">
                                        <form action="{{ route('builder.update', $component) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-check form-switch mb-4">
                                                <input class="form-check-input" type="checkbox" name="is_active" 
                                                       id="active-{{ $component->id }}" 
                                                       {{ $component->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="active-{{ $component->id }}">
                                                    <i class="bi bi-power"></i> Composant actif
                                                </label>
                                            </div>

                                            @include('dashboard.builder.partials.' . $component->type, [
                                                'content' => $component->content,
                                                'componentId' => $component->id,
                                            ])

                                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="bi bi-check-lg"></i> Enregistrer les modifications
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal pour ajouter un composant -->
<div class="modal fade" id="addComponentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Ajouter un composant</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('builder.store') }}" method="POST">
                @csrf
                <input type="hidden" name="shop_id" id="shopIdInput" value="{{ $shop->id }}">
                <input type="hidden" name="type" id="componentType">
                <div class="modal-body text-center">
                    <i id="modalIcon" class="display-4 mb-3"></i>
                    <h5 id="modalTitle" class="mb-2"></h5>
                    <p id="modalDescription" class="text-muted mb-4"></p>
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Ce composant sera ajouté à la fin de votre page d'accueil.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Modal component selection
    const addComponentModal = document.getElementById('addComponentModal');
    addComponentModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const type = button.getAttribute('data-type');
        
        const componentData = {
            slider: {
                icon: 'bi-images text-primary',
                title: 'Slider / Carousel',
                description: 'Ajoutez un diaporama d\'images avec titres et descriptions.'
            },
            categories: {
                icon: 'bi-grid-3x3-gap text-success',
                title: 'Catégories',
                description: 'Affichez vos catégories de produits dans une grille ou un slider.'
            },
            premium_categories: {
                icon: 'bi-star-fill text-warning',
                title: 'Catégories Premium',
                description: 'Mettez en avant certaines catégories avec un badge spécial.'
            },
            banner: {
                icon: 'bi-megaphone text-info',
                title: 'Bandeau défilant',
                description: 'Ajoutez un bandeau animé avec un message personnalisé.'
            },
            reviews: {
                icon: 'bi-chat-quote text-secondary',
                title: 'Avis Clients',
                description: 'Affichez les témoignages de vos clients satisfaits.'
            }
        };
        
        const data = componentData[type];
        document.getElementById('componentType').value = type;
        // keep selected shop in sync
        const activeShopEl = document.getElementById('activeShopId');
        const shopId = activeShopEl ? activeShopEl.value : '{{ $shop->id }}';
        document.getElementById('shopIdInput').value = shopId;
        document.getElementById('modalIcon').className = 'display-4 ' + data.icon;
        document.getElementById('modalTitle').textContent = data.title;
        document.getElementById('modalDescription').textContent = data.description;
    });

    // Sortable
    const el = document.getElementById('components-list');
    if (el) {
        new Sortable(el, {
            handle: '.handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function() {
                const order = [];
                document.querySelectorAll('.component-item').forEach(item => {
                    order.push(item.dataset.id);
                });

                fetch('{{ route("builder.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Ordre mis à jour avec succès', 'success');
                    }
                });
            }
        });
    }

    // Show toast notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed top-0 end-0 m-3`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        document.body.appendChild(toast);
        new bootstrap.Toast(toast).show();
        setTimeout(() => toast.remove(), 5000);
    }
</script>
@endpush

<style>
    .sortable-ghost {
        opacity: 0.5;
        background: #f8f9fa;
    }
    .sortable-chosen {
        border: 2px dashed #0d6efd;
    }
    .sortable-drag {
        opacity: 0.8;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .handle { cursor: grab; }
    .handle:active { cursor: grabbing; }
    .cursor-pointer { cursor: pointer; }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    .list-group-item-action:hover {
        background-color: #f8f9fa;
    }
    .component-item {
        transition: all 0.2s ease;
    }
    .component-item:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .component-form-wrapper {
        border-left: 3px solid #0d6efd;
    }
</style>
@endsection
