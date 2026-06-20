@extends('shop.layouts.app')

@section('title', 'Mes commandes - ' . $shop->name)

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Mes commandes</h4>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th># Commande</th>
                                        <th>Boutique</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->shop->name ?? 'N/A' }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($order->total, 2, ',', ' ') }} TND</td>
                                            <td>
                                                <a href="{{ route('shop.orders.show', ['subdomain' => $shop->subdomain, 'id' => $order->id]) }}" class="btn btn-sm btn-primary">
                                                    Voir
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $orders->links() }}
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x fs-1 text-muted"></i>
                            <h5 class="mt-3">Aucune commande trouvée</h5>
                            <p class="text-muted">Vous n'avez pas encore passé de commande sur cette boutique.</p>
                            <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain]) }}" class="btn btn-primary">
                                <i class="bi bi-shop me-1"></i> Aller à la boutique
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
