@extends('shop.layouts.app')

@section('title', 'Commande #' . $order->order_number . ' - ' . $shop->name)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Commande #{{ $order->order_number }}</h4>
                    <p class="text-muted mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Boutique</h5>
                            <p class="mb-1"><strong>{{ $order->shop->name }}</strong></p>
                            <p class="text-muted mb-0">{{ $order->shop->subdomain }}.shoopino.test</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5>Statut</h5>
                            <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Informations client</h5>
                            <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
                            <p class="mb-1">{{ $order->customer_email }}</p>
                            <p class="mb-0">{{ $order->customer_phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Adresse de livraison</h5>
                            <p class="mb-1">{{ $order->shipping_address }}</p>
                            <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                            <p class="mb-0">{{ $order->shipping_country }}</p>
                        </div>
                    </div>
                    
                    <h5>Articles commandés</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Article</th>
                                    <th>Quantité</th>
                                    <th>Prix unitaire</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->unit_price, 2, ',', ' ') }} TND</td>
                                        <td>{{ number_format($item->line_total, 2, ',', ' ') }} TND</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Sous-total</strong></td>
                                    <td><strong>{{ number_format($order->subtotal, 2, ',', ' ') }} TND</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Frais de livraison</strong></td>
                                    <td><strong>{{ number_format($order->shipping_total, 2, ',', ' ') }} TND</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Réduction</strong></td>
                                    <td><strong>{{ number_format($order->discount_total, 2, ',', ' ') }} TND</strong></td>
                                </tr>
                                <tr class="table-primary">
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td><strong>{{ number_format($order->total, 2, ',', ' ') }} TND</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('shop.orders') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Retour aux commandes
                        </a>
                        <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain]) }}" class="btn btn-primary">
                            Continuer les achats <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection