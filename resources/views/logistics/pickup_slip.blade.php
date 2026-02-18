@extends('layouts.dashboard')

@section('title', 'Bon de ramassage')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-file-earmark-text"></i> Bon de ramassage</h2>
    <a href="#" class="btn btn-outline-secondary" onclick="window.print(); return false;">
        <i class="bi bi-printer"></i> Imprimer
    </a>
</div>

<div class="card">
    <div class="card-body">
        <p class="text-muted mb-3">Généré le {{ now()->format('d/m/Y H:i') }}</p>

        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Boutique</th>
                            <th>Commande</th>
                            <th>Client</th>
                            <th>Adresse</th>
                            <th>Signature</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->shop->name ?? '—' }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->customer_name ?? '—' }}</td>
                                <td style="min-width: 260px;">
                                    {{ $order->shipping_address }}<br>
                                    {{ $order->shipping_city }} {{ $order->shipping_postal_code }}<br>
                                    {{ $order->shipping_country }}
                                </td>
                                <td style="width: 200px;"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">Aucune commande en attente.</p>
        @endif
    </div>
</div>
@endsection

