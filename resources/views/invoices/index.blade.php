@extends('layouts.dashboard')

@section('title', 'Factures')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-receipt"></i> Historique des factures</h2>
</div>

<div class="card">
    <div class="card-body">
        @if($invoices->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>N° facture</th>
                            <th>Commande</th>
                            <th>Boutique</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td><strong>{{ $invoice->invoice_number }}</strong></td>
                                <td>{{ $invoice->order->order_number ?? '—' }}</td>
                                <td>{{ $invoice->shop->name ?? '—' }}</td>
                                <td>{{ $invoice->issued_at?->format('d/m/Y') ?? '—' }}</td>
                                <td>{{ number_format($invoice->total ?? 0, 2, ',', ' ') }} TND</td>
                                <td>
                                    @if($invoice->order)
                                        <a href="{{ route('invoices.show', $invoice->order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $invoices->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-receipt" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucune facture pour le moment.</p>
            </div>
        @endif
    </div>
</div>
@endsection

