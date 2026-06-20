@extends('layouts.dashboard')

@section('title', 'Facture')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div class="grid h-12 w-12 place-items-center rounded-2xl bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200">
                    <i class="bi bi-exclamation-triangle text-xl"></i>
                </div>
                <div class="min-w-0">
                    <h2 class="text-lg font-semibold text-slate-900 mb-1">Aucune facture disponible</h2>
                    <p class="text-sm text-slate-600 mb-0">
                        Aucune facture n’a été générée pour la commande
                        <span class="font-semibold text-slate-900">{{ $order->order_number }}</span>.
                    </p>
                    <p class="mt-2 text-xs text-slate-500 mb-0">
                        Vous pouvez la générer maintenant, puis l’imprimer ou la télécharger en PDF.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row gap-2">
                <a href="{{ route('orders.show', $order) }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                    <i class="bi bi-arrow-left"></i>
                    Retour commande
                </a>

                <form method="POST" action="{{ route('invoices.generate', $order) }}" class="sm:flex-1">
                    @csrf
                    <button class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
                            type="submit">
                        <i class="bi bi-receipt"></i>
                        Générer la facture
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

