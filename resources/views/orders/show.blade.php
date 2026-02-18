@extends('layouts.dashboard')

@section('title', 'Détail commande')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0"><i class="bi bi-receipt"></i> {{ $order->order_number }}</h2>
        <small class="text-muted">Créée le {{ $order->created_at?->format('d/m/Y H:i') }} — Boutique: {{ $order->shop->name ?? '—' }}</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Produits</strong>
                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Qté</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product_name }}</strong>
                                        @if($item->sku)
                                            <br><small class="text-muted">SKU: {{ $item->sku }}</small>
                                        @endif
                                    </td>
                                    <td>{{ number_format($item->unit_price, 2, ',', ' ') }} TND</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->line_total, 2, ',', ' ') }} TND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    <div style="min-width: 250px;">
                        <div class="d-flex justify-content-between">
                            <span>Sous-total</span>
                            <strong>{{ number_format($order->subtotal ?? 0, 2, ',', ' ') }} TND</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Livraison</span>
                            <strong>{{ number_format($order->shipping_total ?? 0, 2, ',', ' ') }} TND</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Remise</span>
                            <strong>-{{ number_format($order->discount_total ?? 0, 2, ',', ' ') }} TND</strong>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span>Total</span>
                            <strong>{{ number_format($order->total ?? 0, 2, ',', ' ') }} TND</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <strong>Historique des statuts</strong>
            </div>
            <div class="card-body">
                @if($order->statusHistories->count())
                    <ul class="list-group">
                        @foreach($order->statusHistories as $h)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <div>
                                        <strong>{{ ucfirst($h->to_status) }}</strong>
                                        @if($h->from_status)
                                            <small class="text-muted">(depuis {{ $h->from_status }})</small>
                                        @endif
                                    </div>
                                    @if($h->note)
                                        <div class="text-muted">{{ $h->note }}</div>
                                    @endif
                                    <small class="text-muted">
                                        {{ $h->created_at?->format('d/m/Y H:i') }}
                                        @if($h->changedBy)
                                            — {{ $h->changedBy->email }}
                                        @endif
                                    </small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">Aucun historique.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <strong>Client</strong>
            </div>
            <div class="card-body">
                <div><strong>Nom:</strong> {{ $order->customer_name ?? '—' }}</div>
                <div><strong>Email:</strong> {{ $order->customer_email ?? '—' }}</div>
                <div><strong>Téléphone:</strong> {{ $order->customer_phone ?? '—' }}</div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <strong>Livraison</strong>
            </div>
            <div class="card-body">
                <div><strong>Adresse:</strong><br>{{ $order->shipping_address ?? '—' }}</div>
                <div class="mt-2"><strong>Ville:</strong> {{ $order->shipping_city ?? '—' }}</div>
                <div><strong>Code postal:</strong> {{ $order->shipping_postal_code ?? '—' }}</div>
                <div><strong>État:</strong> {{ $order->shipping_state ?? '—' }}</div>
                <div><strong>Pays:</strong> {{ $order->shipping_country ?? '—' }}</div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <strong>Paiement</strong>
            </div>
            <div class="card-body">
                <div><strong>Méthode:</strong> {{ $order->payment_method ?? '—' }}</div>
                <div><strong>Statut:</strong> {{ $order->payment_status ?? '—' }}</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Actions</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('orders.status', $order) }}" class="mb-3">
                    @csrf
                    <label class="form-label">Modifier statut</label>
                    <select name="status" class="form-select mb-2" required>
                        @foreach($statuses as $s)
                            <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="note" class="form-control mb-2" placeholder="Note (optionnel)">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-arrow-repeat"></i> Mettre à jour
                    </button>
                </form>

                <div class="d-grid gap-2">
                    <a class="btn btn-outline-secondary" href="#" onclick="window.print(); return false;">
                        <i class="bi bi-printer"></i> Imprimer
                    </a>
                    <form method="POST" action="{{ route('invoices.generate', $order) }}">
                        @csrf
                        <button class="btn btn-outline-primary w-100" type="submit">
                            <i class="bi bi-receipt"></i> Générer facture
                        </button>
                    </form>
                    @if($order->invoice)
                        <a class="btn btn-outline-primary" href="{{ route('invoices.show', $order) }}">
                            <i class="bi bi-eye"></i> Voir facture
                        </a>
                        <a class="btn btn-outline-danger" href="{{ route('invoices.pdf', $order) }}">
                            <i class="bi bi-file-earmark-pdf"></i> Télécharger PDF
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

