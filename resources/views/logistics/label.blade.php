@extends('layouts.dashboard')

@section('title', 'Étiquette')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-tag"></i> Étiquette colis</h2>
    <a href="#" class="btn btn-outline-secondary" onclick="window.print(); return false;">
        <i class="bi bi-printer"></i> Imprimer
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Expéditeur</h5>
                <div><strong>{{ $order->shop->company_name ?: $order->shop->name }}</strong></div>
                <div class="text-muted">{{ $order->shop->street }}</div>
                <div class="text-muted">{{ $order->shop->city }} {{ $order->shop->postal_code }}</div>
                <div class="text-muted">{{ $order->shop->contact_phone }}</div>
            </div>
            <div class="col-md-6">
                <h5>Destinataire</h5>
                <div><strong>{{ $order->customer_name ?? '—' }}</strong></div>
                <div class="text-muted">{{ $order->customer_phone ?? '' }}</div>
                <div class="text-muted mt-2">
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }} {{ $order->shipping_postal_code }}<br>
                    {{ $order->shipping_country }}
                </div>
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-between">
            <div>
                <div class="text-muted">Commande</div>
                <div style="font-size: 24px;"><strong>{{ $order->order_number }}</strong></div>
            </div>
            <div class="text-end">
                <div class="text-muted">Statut emballage</div>
                <div><span class="badge bg-secondary">{{ $order->packing?->status ?? 'pending' }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection

