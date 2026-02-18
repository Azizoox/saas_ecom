<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .row { display: flex; justify-content: space-between; }
        .muted { color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f6f6f6; text-align: left; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Facture {{ $invoice->invoice_number }}</h2>
    <p class="muted">Commande {{ $order->order_number }} — Date {{ $invoice->issued_at?->format('d/m/Y') }}</p>

    <div class="row">
        <div>
            <strong>{{ $order->shop->company_name ?: $order->shop->name }}</strong><br>
            <span class="muted">{{ $order->shop->street }}</span><br>
            <span class="muted">{{ $order->shop->city }} {{ $order->shop->postal_code }}</span><br>
            <span class="muted">{{ $order->shop->contact_email }}</span><br>
            <span class="muted">{{ $order->shop->contact_phone }}</span>
        </div>
        <div>
            <strong>{{ $order->customer_name ?? '—' }}</strong><br>
            <span class="muted">{{ $order->customer_email ?? '' }}</span><br>
            <span class="muted">{{ $order->customer_phone ?? '' }}</span><br><br>
            <span class="muted">{{ $order->shipping_address }}</span><br>
            <span class="muted">{{ $order->shipping_city }} {{ $order->shipping_postal_code }}</span><br>
            <span class="muted">{{ $order->shipping_country }}</span>
        </div>
    </div>

    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th class="text-right">Prix</th>
            <th class="text-right">Qté</th>
            <th class="text-right">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td class="text-right">{{ number_format($item->unit_price, 2, ',', ' ') }} TND</td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->line_total, 2, ',', ' ') }} TND</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <table style="width: 40%; margin-left: auto;">
        <tbody>
        <tr>
            <td>Sous-total</td>
            <td class="text-right"><strong>{{ number_format($invoice->subtotal ?? 0, 2, ',', ' ') }} TND</strong></td>
        </tr>
        <tr>
            <td>Taxes</td>
            <td class="text-right"><strong>{{ number_format($invoice->tax_total ?? 0, 2, ',', ' ') }} TND</strong></td>
        </tr>
        <tr>
            <td>Total</td>
            <td class="text-right"><strong>{{ number_format($invoice->total ?? 0, 2, ',', ' ') }} TND</strong></td>
        </tr>
        </tbody>
    </table>
</body>
</html>

