@extends('layouts.dashboard')

@section('title', 'Retours')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-arrow-counterclockwise"></i> Gestion des retours</h2>
</div>

<div class="card">
    <div class="card-body">
        @if($returns->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Boutique</th>
                            <th>Statut</th>
                            <th>Motif</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($returns as $ret)
                            <tr>
                                <td>
                                    @if($ret->order)
                                        <a href="{{ route('orders.show', $ret->order) }}">{{ $ret->order->order_number }}</a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $ret->shop->name ?? '—' }}</td>
                                <td><span class="badge bg-secondary">{{ $ret->status }}</span></td>
                                <td style="max-width: 360px;">
                                    <div class="text-truncate" title="{{ $ret->reason }}">{{ $ret->reason ?? '—' }}</div>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('logistics.returns.update', $ret) }}" class="d-flex gap-2">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm" style="max-width: 150px;">
                                            <option value="in_progress" @selected($ret->status === 'in_progress')>En cours</option>
                                            <option value="accepted" @selected($ret->status === 'accepted')>Accepté</option>
                                            <option value="refused" @selected($ret->status === 'refused')>Refusé</option>
                                        </select>
                                        <input type="text" name="reason" class="form-control form-control-sm" placeholder="Motif" value="{{ $ret->reason }}">
                                        <button class="btn btn-sm btn-outline-primary" type="submit">
                                            <i class="bi bi-check2"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $returns->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-arrow-counterclockwise" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">Aucun retour pour le moment.</p>
            </div>
        @endif
    </div>
</div>
@endsection

