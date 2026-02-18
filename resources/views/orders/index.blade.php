@extends('layouts.dashboard')

@section('title', 'Commandes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-cart-check"></i> Toutes les commandes</h2>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nouvelle commande
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('orders.index') }}" class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label">Statut</label>
                <select name="status" class="form-select">
                    <option value="">Tous</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date (de)</label>
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">Date (à)</label>
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Client</label>
                <input type="text" name="client" value="{{ $filters['client'] ?? '' }}" class="form-control" placeholder="Nom, email, téléphone">
            </div>
            <div class="col-md-2">
                <label class="form-label">N° commande</label>
                <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="ORD-...">
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Boutique</th>
                            <th>Client</th>
                            <th>Statut</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><strong>{{ $order->order_number }}</strong></td>
                                <td>{{ $order->shop->name ?? '—' }}</td>
                                <td>
                                    {{ $order->customer_name ?? '—' }}
                                    @if($order->customer_phone)
                                        <br><small class="text-muted">{{ $order->customer_phone }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td>{{ number_format($order->total ?? 0, 2, ',', ' ') }} TND</td>
                                <td>{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-cart-check" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucune commande pour le moment.</p>
                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Créer une commande
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

