@extends('layouts.dashboard')

@section('title', 'Facture')

@section('content')
<div class="alert alert-warning">
    Aucune facture n’a été générée pour la commande <strong>{{ $order->order_number }}</strong>.
</div>

<form method="POST" action="{{ route('invoices.generate', $order) }}">
    @csrf
    <button class="btn btn-primary" type="submit">
        <i class="bi bi-receipt"></i> Générer la facture
    </button>
</form>
@endsection

