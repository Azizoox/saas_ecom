<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $shops = $user->shops;

        $invoices = Invoice::query()
            ->whereIn('shop_id', $shops->pluck('id'))
            ->with(['order', 'shop'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('invoices.index', [
            'invoices' => $invoices,
        ]);
    }

    public function generate(Order $order): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->shops->contains('id', $order->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        $order->loadMissing(['items', 'shop']);

        DB::transaction(function () use ($order) {
            if ($order->invoice) {
                return;
            }

            $order->recalculateTotals();
            $order->save();

            $order->invoice()->create([
                'shop_id' => $order->shop_id,
                'subtotal' => $order->subtotal ?? 0,
                'tax_total' => 0,
                'total' => $order->total ?? 0,
                'issued_at' => now()->toDateString(),
            ]);
        });

        return redirect()->route('invoices.show', $order)
            ->with('success', 'Facture générée.');
    }

    public function show(Order $order): View
    {
        $user = auth()->user();
        if (!$user->shops->contains('id', $order->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        $order->load(['invoice', 'items', 'shop']);

        if (!$order->invoice) {
            return view('invoices.missing', ['order' => $order]);
        }

        return view('invoices.show', [
            'order' => $order,
            'invoice' => $order->invoice,
        ]);
    }

    public function downloadPdf(Order $order)
    {
        $user = auth()->user();
        if (!$user->shops->contains('id', $order->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        $order->load(['invoice', 'items', 'shop']);
        if (!$order->invoice) {
            return redirect()->route('invoices.show', $order)->withErrors(['error' => 'Aucune facture.']);
        }

        // Dompdf install can fail on some Windows setups (file locks).
        // We guard so the rest of the module works even without PDF.
        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return back()->withErrors(['error' => 'Génération PDF indisponible (Dompdf non installé).']);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', [
            'order' => $order,
            'invoice' => $order->invoice,
        ]);

        $filename = $order->invoice->invoice_number . '.pdf';
        return $pdf->download($filename);
    }
}

