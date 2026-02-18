@extends('layouts.dashboard')

@section('title', 'Ramassage')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-arrow-in-down"></i> Commandes à ramasser</h2>
    <a href="{{ route('logistics.pickups.slip') }}" class="btn btn-outline-primary" target="_blank">
        <i class="bi bi-file-earmark-text"></i> Bon de ramassage
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Boutique</th>
                            <th>Client</th>
                            <th>Statut ramassage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><a href="{{ route('orders.show', $order) }}">{{ $order->order_number }}</a></td>
                                <td>{{ $order->shop->name ?? '—' }}</td>
                                <td>{{ $order->customer_name ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ $order->pickup?->status ?? 'pending' }}</span>
                                </td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('logistics.pickups.picked', $order) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-success" type="submit">
                                            <i class="bi bi-check2"></i> Marquer ramassé
                                        </button>
                                    </form>
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
                <i class="bi bi-box-arrow-in-down" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucune commande à ramasser.</p>
            </div>
        @endif
    </div>
</div>
@endsection

