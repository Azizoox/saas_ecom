@extends('layouts.dashboard')

@section('title', 'Super Admin - Tableau de bord')

@section('content')
<div class="container-fluid">
    <!-- Welcome Card -->
  

    <!-- KPI Cards Row 1 - Vue d'ensemble -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Total Utilisateurs</h6>
                        <i class="bi bi-people text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                    <h3 class="mb-2">{{ $stats['users_count'] }}</h3>
                    <small class="text-success">
                        <i class="bi bi-arrow-up"></i> {{ $stats['users_today'] }} aujourd'hui
                    </small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Boutiques</h6>
                        <i class="bi bi-shop text-success" style="font-size: 1.5rem;"></i>
                    </div>
                    <h3 class="mb-2">{{ $stats['shops_count'] }}</h3>
                    <small class="text-info">
                        {{ $stats['shops_active'] }} actives • {{ $stats['shops_inactive'] }} inactives
                    </small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Produits</h6>
                        <i class="bi bi-box-seam text-info" style="font-size: 1.5rem;"></i>
                    </div>
                    <h3 class="mb-2">{{ $stats['products_count'] }}</h3>
                    <small class="text-success">
                        {{ $stats['products_active'] }} actifs
                    </small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Commandes</h6>
                        <i class="bi bi-cart-check text-warning" style="font-size: 1.5rem;"></i>
                    </div>
                    <h3 class="mb-2">{{ $stats['orders_count'] }}</h3>
                    <small class="text-warning">
                        {{ $stats['orders_pending'] }} en attente
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Chiffre d'affaires -->
    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                <div class="card-body">
                    <h6 class="opacity-90 mb-1">💰 Chiffre d'affaires total</h6>
                    <h2 class="mb-2">{{ number_format($stats['orders_total_amount'], 2) }} TND</h2>
                    <small class="opacity-90">
                        Mois: {{ number_format($stats['orders_this_month'], 2) }} TND
                    </small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 bg-success text-white">
                <div class="card-body">
                    <h6 class="opacity-90 mb-1">📈 Panier moyen</h6>
                    <h2 class="mb-2">{{ number_format($stats['average_order_value'], 2) }} TND</h2>
                    <small class="opacity-90">
                        {{ $stats['orders_completed'] }} commandes complétées
                    </small>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 bg-danger text-white">
                <div class="card-body">
                    <h6 class="opacity-90 mb-1">❌ Commandes annulées</h6>
                    <h2 class="mb-2">{{ $stats['orders_cancelled'] }}</h2>
                    <small class="opacity-90">
                        Voir la liste complète
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Statuts des commandes -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div style="font-size: 2rem; margin-bottom: 10px;">🆕</div>
                    <h5>{{ $stats['orders_count'] - $stats['orders_completed'] - $stats['orders_cancelled'] }}</h5>
                    <small class="text-muted">Commandes en cours</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div style="font-size: 2rem; margin-bottom: 10px;">✅</div>
                    <h5>{{ $stats['orders_completed'] }}</h5>
                    <small class="text-muted">Commandes complétées</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div style="font-size: 2rem; margin-bottom: 10px;">📦</div>
                    <h5>{{ $stats['categories_count'] }}</h5>
                    <small class="text-muted">Catégories</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div style="font-size: 2rem; margin-bottom: 10px;">👥</div>
                    <h5>{{ $stats['users_this_month'] }}</h5>
                    <small class="text-muted">Nouveaux ce mois</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Sections principales -->
    <div class="row g-3 mb-4">
        <!-- Derniers utilisateurs -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-people me-2 text-primary"></i>Derniers utilisateurs</h5>
                </div>
                <div class="card-body p-0">
                    @if($recentUsers->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($recentUsers as $u)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $u->full_name }}</strong>
                                            <br><small class="text-muted">{{ $u->email }}</small>
                                        </div>
                                        <span class="badge bg-secondary">{{ $u->role ?? 'Client' }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted p-3 mb-0 text-center">Aucun utilisateur.</p>
                    @endif
                </div>
                <div class="card-footer bg-light">
                    <a href="{{ route('super-admin.users.index') }}" class="btn btn-sm btn-primary w-100">
                        <i class="bi bi-list"></i> Voir tous les utilisateurs
                    </a>
                </div>
            </div>
        </div>
        <!-- Dernières boutiques -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-shop me-2 text-success"></i>Dernières boutiques</h5>
                </div>
                <div class="card-body p-0">
                    @if($recentShops->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($recentShops as $s)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $s->name }}</strong>
                                            <br><small class="text-muted">{{ $s->subdomain }}</small>
                                        </div>
                                        <span class="badge bg-{{ $s->status === 'active' ? 'success' : 'secondary' }}">{{ $s->status }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted p-3 mb-0 text-center">Aucune boutique.</p>
                    @endif
                </div>
                <div class="card-footer bg-light">
                    <a href="#" class="btn btn-sm btn-success w-100">
                        <i class="bi bi-shop"></i> Gérer les boutiques
                    </a>
                </div>
            </div>
        </div>
        <!-- Dernières commandes -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-cart-check me-2 text-warning"></i>Dernières commandes</h5>
                </div>
                <div class="card-body p-0">
                    @if($recentOrders->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($recentOrders->take(5) as $o)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $o->order_number }}</strong>
                                            <br><small class="text-muted">{{ $o->shop->name ?? '-' }} · {{ number_format($o->total, 0, ',', ' ') }} TND</small>
                                        </div>
                                        <span class="badge bg-{{ $o->status === 'new' ? 'warning' : ($o->status === 'completed' ? 'success' : 'info') }}">{{ $o->status }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted p-3 mb-0 text-center">Aucune commande.</p>
                    @endif
                </div>
                <div class="card-footer bg-light">
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-warning w-100">
                        <i class="bi bi-list"></i> Voir toutes les commandes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Info -->
    
</div>

@push('styles')
<style>
    .stat-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .bg-gradient {
        background-attachment: fixed;
    }
    
    .card-header {
        border-bottom: 1px solid #e9ecef;
    }
</style>
@endpush
@endsection
