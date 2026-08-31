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
    <h2>Facture <?php echo e($invoice->invoice_number); ?></h2>
    <p class="muted">Commande <?php echo e($order->order_number); ?> — Date <?php echo e($invoice->issued_at?->format('d/m/Y')); ?></p>

    <div class="row">
        <div>
            <strong><?php echo e($order->shop->company_name ?: $order->shop->name); ?></strong><br>
            <span class="muted"><?php echo e($order->shop->street); ?></span><br>
            <span class="muted"><?php echo e($order->shop->city); ?> <?php echo e($order->shop->postal_code); ?></span><br>
            <span class="muted"><?php echo e($order->shop->contact_email); ?></span><br>
            <span class="muted"><?php echo e($order->shop->contact_phone); ?></span>
        </div>
        <div>
            <strong><?php echo e($order->customer_name ?? '—'); ?></strong><br>
            <span class="muted"><?php echo e($order->customer_email ?? ''); ?></span><br>
            <span class="muted"><?php echo e($order->customer_phone ?? ''); ?></span><br><br>
            <span class="muted"><?php echo e($order->shipping_address); ?></span><br>
            <span class="muted"><?php echo e($order->shipping_city); ?> <?php echo e($order->shipping_postal_code); ?></span><br>
            <span class="muted"><?php echo e($order->shipping_country); ?></span>
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
        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->product_name); ?></td>
                <td class="text-right"><?php echo e(number_format($item->unit_price, 2, ',', ' ')); ?> TND</td>
                <td class="text-right"><?php echo e($item->quantity); ?></td>
                <td class="text-right"><?php echo e(number_format($item->line_total, 2, ',', ' ')); ?> TND</td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <table style="width: 40%; margin-left: auto;">
        <tbody>
        <tr>
            <td>Sous-total</td>
            <td class="text-right"><strong><?php echo e(number_format($invoice->subtotal ?? 0, 2, ',', ' ')); ?> TND</strong></td>
        </tr>
        <tr>
            <td>Taxes</td>
            <td class="text-right"><strong><?php echo e(number_format($invoice->tax_total ?? 0, 2, ',', ' ')); ?> TND</strong></td>
        </tr>
        <tr>
            <td>Total</td>
            <td class="text-right"><strong><?php echo e(number_format($invoice->total ?? 0, 2, ',', ' ')); ?> TND</strong></td>
        </tr>
        </tbody>
    </table>
</body>
</html>

<?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/invoices/pdf.blade.php ENDPATH**/ ?>