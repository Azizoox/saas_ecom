@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Card -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">👋 Bonjour, {{ explode(' ', $user->full_name)[0] ?? $user->email }}!</h2>
                        <p class="text-muted mb-0">Bienvenue dans votre espace de gestion Shoopino</p>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-shop text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Boutiques</h6>
                        <h2 class="mb-0 text-primary">{{ $shops->count() }}</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-shop text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-success">
                        <i class="bi bi-arrow-up-circle"></i> {{ $shops->where('status', 'active')->count() }} actives
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Produits</h6>
                        <h2 class="mb-0 text-success">{{ $totalProducts ?? 0 }}</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-box-seam text-success" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> Total dans toutes les boutiques
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Catégories</h6>
                        <h2 class="mb-0 text-info">{{ $totalCategories ?? 0 }}</h2>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-tags text-info" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bi bi-collection"></i> Organisez vos produits
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Commandes</h6>
                        <h2 class="mb-0 text-warning">{{ $totalOrders ?? 0 }}</h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="bi bi-cart-check text-warning" style="font-size: 1.5rem;"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="bi bi-graph-up"></i> En attente de traitement
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Shops Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-shop-window me-2 text-primary"></i>
                        Mes boutiques
                    </h5>
                    
                </div>
            </div>
            <div class="card-body">
                @if($shops->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Sous-domaine</th>
                                    <th>Statut</th>
                                    <th>Produits</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shops as $shop)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                                <i class="bi bi-shop text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $shop->name }}</h6>
                                                <small class="text-muted">Créée le {{ $shop->created_at->format('d/m/Y') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain]) }}" 
                                           target="_blank" 
                                           class="text-decoration-none">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>
                                            {{ $shop->subdomain }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $shop->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($shop->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ $shop->products()->count() }} produits
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain]) }}" 
                                               target="_blank" 
                                               class="btn btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-secondary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-shop text-muted" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Aucune boutique trouvée</h4>
                        <p class="text-muted">Commencez par créer votre première boutique en ligne.</p>
                        <a href="#" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Créer une boutique
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mt-4">
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up me-2 text-primary"></i>
                    Évolution des ventes
                </h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-pie-chart me-2 text-success"></i>
                    Répartition des catégories
                </h5>
            </div>
            <div class="card-body">
                <canvas id="categoriesChart" height="250"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    <i class="bi bi-bar-chart me-2 text-info"></i>
                    Statut des commandes
                </h5>
            </div>
            <div class="card-body">
                <canvas id="ordersChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Trend Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Ventes (TND)',
                data: [12000, 19000, 15000, 18000, 22000, 19500, 24000, 21000, 26000, 23000, 28000, 31000],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // Categories Distribution Chart
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    const categoriesChart = new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Électronique', 'Vêtements', 'Maison', 'Sports', 'Beauté'],
            datasets: [{
                data: [35, 25, 20, 12, 8],
                backgroundColor: [
                    '#3b82f6',
                    '#10b981',
                    '#8b5cf6',
                    '#f59e0b',
                    '#ef4444'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            },
            cutout: '70%'
        }
    });
    
    // Orders Status Chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: ['En attente', 'En cours', 'Expédiées', 'Livrées', 'Annulées'],
            datasets: [{
                label: 'Commandes',
                data: [12, 19, 3, 5, 2],
                backgroundColor: [
                    '#f59e0b',
                    '#3b82f6',
                    '#10b981',
                    '#8b5cf6',
                    '#ef4444'
                ],
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endpush
