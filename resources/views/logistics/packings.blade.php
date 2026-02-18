@extends('layouts.dashboard')

@section('title', 'Emballage')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box2"></i> Colis à emballer</h2>
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
                            <th>Statut emballage</th>
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
                                    <span class="badge bg-warning text-dark">{{ $order->packing?->status ?? 'pending' }}</span>
                                </td>
                                <td class="text-end d-flex justify-content-end gap-2">
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('logistics.packings.label', $order) }}" target="_blank">
                                        <i class="bi bi-tag"></i> Étiquette
                                    </a>
                                    <form method="POST" action="{{ route('logistics.packings.packed', $order) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-success" type="submit">
                                            <i class="bi bi-check2"></i> Valider
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
                <i class="bi bi-box2" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun colis à emballer.</p>
            </div>
        @endif
    </div>
</div>
@endsection

