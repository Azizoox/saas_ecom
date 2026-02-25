@extends('layouts.dashboard')

@section('title', 'Commandes POS')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-list-check me-2"></i>Commandes POS
        </h2>
        <a href="{{ route('pos.index') }}" class="btn btn-primary">
            <i class="bi bi-cart-plus me-2"></i>Nouvelle Commande
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>N° Commande</th>
                            <th>Date</th>
                            <th>Agent</th>
                            <th>Caisse</th>
                            <th>Paiement</th>
                            <th>Articles</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <strong>{{ $order->formatted_order_number }}</strong>
                                </td>
                                <td>
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    {{ $order->user->getFullNameAttribute() }}
                                </td>
                                <td>
                                    @if($order->cashRegisterSession && $order->cashRegisterSession->cashRegister)
                                        {{ $order->cashRegisterSession->cashRegister->name }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $order->payment_method_label }}</span>
                                </td>
                                <td>
                                    {{ $order->orderItems->count() }}
                                </td>
                                <td>
                                    <strong>{{ number_format($order->total_amount, 3, '.', ' ') }} TND</strong>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($order->status === 'completed') bg-success 
                                        @elseif($order->status === 'pending') bg-warning 
                                        @else bg-secondary @endif">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#orderDetailsModal{{ $order->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="bi bi-cart-x" style="font-size: 3rem; color: #6c757d;"></i>
                                    <h4 class="mt-3">Aucune commande</h4>
                                    <p class="text-muted">Les commandes POS apparaîtront ici</p>
                                    <a href="{{ route('pos.index') }}" class="btn btn-primary">
                                        <i class="bi bi-cart-plus me-2"></i>Créer une commande
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Order Details Modals -->
@foreach($orders as $order)
<div class="modal fade" id="orderDetailsModal{{ $order->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails Commande - {{ $order->formatted_order_number }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations Client</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Agent:</strong></td>
                                <td>{{ $order->user->getFullNameAttribute() }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date:</strong></td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Statut:</strong></td>
                                <td><span class="badge 
                                    @if($order->status === 'completed') bg-success 
                                    @elseif($order->status === 'pending') bg-warning 
                                    @else bg-secondary @endif">
                                    {{ $order->status_label }}
                                </span></td>
                            </tr>
                            <tr>
                                <td><strong>Paiement:</strong></td>
                                <td><span class="badge bg-info">{{ $order->payment_method_label }}</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Informations Caisse</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Caisse:</strong></td>
                                <td>
                                    @if($order->cashRegisterSession && $order->cashRegisterSession->cashRegister)
                                        {{ $order->cashRegisterSession->cashRegister->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            @if($order->cashRegisterSession && $order->cashRegisterSession->cashRegister->location)
                            <tr>
                                <td><strong>Emplacement:</strong></td>
                                <td>{{ $order->cashRegisterSession->cashRegister->location }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <h6 class="mt-4">Articles</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Qté</th>
                                <th>Prix Unitaire</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_price, 3, '.', ' ') }} TND</td>
                                    <td>{{ number_format($item->line_total, 3, '.', ' ') }} TND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6 offset-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td>Sous-total:</td>
                                <td class="text-end">{{ number_format($order->subtotal, 3, '.', ' ') }} TND</td>
                            </tr>
                            <tr>
                                <td>TVA:</td>
                                <td class="text-end">{{ number_format($order->tax_amount, 3, '.', ' ') }} TND</td>
                            </tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td class="text-end"><strong>{{ number_format($order->total_amount, 3, '.', ' ') }} TND</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Imprimer</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection