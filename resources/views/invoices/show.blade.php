@extends('layouts.dashboard')

@section('title', 'Facture')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0"><i class="bi bi-receipt"></i> {{ $invoice->invoice_number }}</h2>
        <small class="text-muted">Commande: {{ $order->order_number }} — Date: {{ $invoice->issued_at?->format('d/m/Y') }}</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour commande
        </a>
        <a href="{{ route('invoices.pdf', $order) }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Télécharger PDF
        </a>
        <a href="#" class="btn btn-outline-secondary" onclick="window.print(); return false;">
            <i class="bi bi-printer"></i> Imprimer
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Boutique</h5>
                <div><strong>{{ $order->shop->company_name ?: $order->shop->name }}</strong></div>
                <div class="text-muted">{{ $order->shop->street }}</div>
                <div class="text-muted">{{ $order->shop->city }} {{ $order->shop->postal_code }}</div>
                <div class="text-muted">{{ $order->shop->contact_email }}</div>
                <div class="text-muted">{{ $order->shop->contact_phone }}</div>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>Client</h5>
                <div><strong>{{ $order->customer_name ?? '—' }}</strong></div>
                <div class="text-muted">{{ $order->customer_email ?? '' }}</div>
                <div class="text-muted">{{ $order->customer_phone ?? '' }}</div>
                <div class="text-muted mt-2">
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }} {{ $order->shipping_postal_code }}<br>
                    {{ $order->shipping_country }}
                </div>
            </div>
        </div>

        <hr>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th class="text-end">Prix</th>
                        <th class="text-end">Qté</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td class="text-end">{{ number_format($item->unit_price, 2, ',', ' ') }} TND</td>
                            <td class="text-end">{{ $item->quantity }}</td>
                            <td class="text-end">{{ number_format($item->line_total, 2, ',', ' ') }} TND</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            <div style="min-width: 280px;">
                <div class="d-flex justify-content-between">
                    <span>Sous-total</span>
                    <strong>{{ number_format($invoice->subtotal ?? 0, 2, ',', ' ') }} TND</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Taxes</span>
                    <strong>{{ number_format($invoice->tax_total ?? 0, 2, ',', ' ') }} TND</strong>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between">
                    <span>Total</span>
                    <strong>{{ number_format($invoice->total ?? 0, 2, ',', ' ') }} TND</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

