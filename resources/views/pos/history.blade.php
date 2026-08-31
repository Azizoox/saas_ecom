@extends('layouts.dashboard')

@section('title', 'Historique Caisse')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-journal-text me-2"></i>Historique Caisse
        </h2>
        <div>
            <a href="{{ route('pos.index') }}" class="btn btn-primary">
                <i class="bi bi-cart me-2"></i>POS
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Espèces</h6>
                            <h3 class="mb-0">{{ number_format($totalCashSales, 3, '.', ' ') }} TND</h3>
                        </div>
                        <i class="bi bi-cash fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total CB</h6>
                            <h3 class="mb-0">{{ number_format($totalCardSales, 3, '.', ' ') }} TND</h3>
                        </div>
                        <i class="bi bi-credit-card fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Ventes</h6>
                            <h3 class="mb-0">{{ number_format($totalSales, 3, '.', ' ') }} TND</h3>
                        </div>
                        <i class="bi bi-graph-up fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Sessions</h6>
                            <h3 class="mb-0">{{ $sessions->count() }}</h3>
                        </div>
                        <i class="bi bi-journals fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Caisse</th>
                            <th>Agent</th>
                            <th>Ouverture</th>
                            <th>Fermeture</th>
                            <th>Commandes</th>
                            <th>Montant Attendu</th>
                            <th>Montant Réel</th>
                            <th>Écart</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions as $session)
                            <tr>
                                <td>
                                    <strong>{{ $session->cashRegister->name }}</strong>
                                    @if($session->cashRegister->location)
                                        <div class="small text-muted">{{ $session->cashRegister->location }}</div>
                                    @endif
                                </td>
                                <td>{{ $session->user->getFullNameAttribute() }}</td>
                                <td>{{ $session->opened_at ? $session->opened_at->format('d/m/Y H:i') : '-' }}</td>
                                <td>{{ $session->closed_at ? $session->closed_at->format('d/m/Y H:i') : '-' }}</td>
                                <td>{{ $session->posOrders->count() }}</td>
                                <td>{{ $session->expected_closing_balance ? number_format($session->expected_closing_balance, 3, '.', ' ') . ' TND' : '-' }}</td>
                                <td>{{ $session->actual_closing_balance ? number_format($session->actual_closing_balance, 3, '.', ' ') . ' TND' : '-' }}</td>
                                <td>
                                    @if($session->difference !== null)
                                        <span class="{{ $session->difference == 0 ? 'text-success' : ($session->difference > 0 ? 'text-success' : 'text-danger') }}">
                                            {{ number_format($session->difference, 3, '.', ' ') }} TND
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($session->status === 'open') bg-success 
                                        @else bg-secondary @endif">
                                        {{ $session->status === 'open' ? 'Ouverte' : 'Fermée' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#sessionDetailsModal{{ $session->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="text-center py-5">
                                    <i class="bi bi-journal-x" style="font-size: 3rem; color: #6c757d;"></i>
                                    <h4 class="mt-3">Aucune session</h4>
                                    <p class="text-muted">Les sessions de caisse apparaîtront ici</p>
                                    <a href="{{ route('pos.index') }}" class="btn btn-primary">
                                        <i class="bi bi-cash-coin me-2"></i>Ouvrir une caisse
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($sessions->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $sessions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Session Details Modals -->
@foreach($sessions as $session)
<div class="modal fade" id="sessionDetailsModal{{ $session->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails Session - {{ $session->cashRegister->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations Session</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Caisse:</strong></td>
                                <td>{{ $session->cashRegister->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Emplacement:</strong></td>
                                <td>{{ $session->cashRegister->location ?? 'Non spécifié' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Agent:</strong></td>
                                <td>{{ $session->user->getFullNameAttribute() }}</td>
                            </tr>
                            <tr>
                                <td><strong>Statut:</strong></td>
                                <td>
                                    @if($session->status === 'open')
                                        <span class="badge bg-success">Ouverte</span>
                                    @else
                                        <span class="badge bg-secondary">Fermée</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Ouverte le:</strong></td>
                                <td>{{ $session->opened_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($session->closed_at)
                            <tr>
                                <td><strong>Fermée le:</strong></td>
                                <td>{{ $session->closed_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Bilan Financier</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Solde Initial:</strong></td>
                                <td class="text-end">{{ number_format($session->opening_balance, 3, '.', ' ') }} TND</td>
                            </tr>
                            <tr>
                                <td><strong>Montant Attendu:</strong></td>
                                <td class="text-end">{{ $session->expected_closing_balance ? number_format($session->expected_closing_balance, 3, '.', ' ') . ' TND' : '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Montant Réel:</strong></td>
                                <td class="text-end">{{ $session->actual_closing_balance ? number_format($session->actual_closing_balance, 3, '.', ' ') . ' TND' : '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Écart:</strong></td>
                                <td class="text-end {{ $session->difference == 0 ? 'text-success' : ($session->difference > 0 ? 'text-success' : 'text-danger') }}">
                                    {{ $session->difference !== null ? number_format($session->difference, 3, '.', ' ') . ' TND' : '-' }}
                                </td>
                            </tr>
                        </table>
                        
                        @if($session->notes)
                        <h6 class="mt-3">Notes</h6>
                        <p class="text-muted">{{ $session->notes }}</p>
                        @endif
                    </div>
                </div>

                <h6 class="mt-4">Commandes de la Session</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>N° Commande</th>
                                <th>Date</th>
                                <th>Articles</th>
                                <th>Total</th>
                                <th>Paiement</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($session->posOrders as $order)
                                <tr>
                                    <td>{{ $order->formatted_order_number }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $order->orderItems->count() }}</td>
                                    <td>{{ number_format($order->total_amount, 3, '.', ' ') }} TND</td>
                                    <td><span class="badge bg-info">{{ $order->payment_method_label }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Aucune commande</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Imprimer Bilan</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection