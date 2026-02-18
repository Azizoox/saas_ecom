@extends('layouts.dashboard')

@section('title', 'Statistiques')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-graph-up"></i> Statistiques des ventes</h2>
    <form method="GET" action="{{ route('stats.sales') }}" class="d-flex gap-2">
        <select name="period" class="form-select">
            <option value="day" @selected($period === 'day')>Jour</option>
            <option value="month" @selected($period === 'month')>Mois</option>
        </select>
        <button class="btn btn-outline-primary" type="submit">
            <i class="bi bi-arrow-repeat"></i>
        </button>
    </form>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total des ventes</h5>
                <h2>{{ number_format($totalSales, 2, ',', ' ') }} TND</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Nombre de commandes</h5>
                <h2>{{ $ordersCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Panier moyen</h5>
                <h2>{{ number_format($avgBasket, 2, ',', ' ') }} TND</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>Ventes par période ({{ $period }})</strong>
    </div>
    <div class="card-body">
        @if($salesByPeriod->count())
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Période</th>
                            <th>Commandes</th>
                            <th>Total ventes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salesByPeriod as $row)
                            <tr>
                                <td>{{ $row->bucket }}</td>
                                <td>{{ $row->orders_count }}</td>
                                <td>{{ number_format($row->total_sales, 2, ',', ' ') }} TND</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted mb-0">Aucune donnée.</p>
        @endif
    </div>
</div>
@endsection

