<?php $__env->startSection('title', 'Facture'); ?>

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-7xl">
    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between mb-6">
        <div class="min-w-0">
            <div class="flex items-center gap-3">
                <div class="grid h-10 w-10 place-items-center rounded-xl bg-slate-900 text-white shadow-sm">
                    <i class="bi bi-receipt text-lg"></i>
                </div>
                <div class="min-w-0">
                    <h2 class="text-xl md:text-2xl font-semibold tracking-tight text-slate-900 truncate">
                        <?php echo e($invoice->invoice_number); ?>

                    </h2>
                    <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-slate-500">
                        <span>Commande: <span class="font-medium text-slate-700"><?php echo e($order->order_number); ?></span></span>
                        <span class="hidden sm:inline">•</span>
                        <span>Date: <?php echo e($invoice->issued_at?->format('d/m/Y')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="<?php echo e(route('orders.show', $order)); ?>"
               class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Retour commande
            </a>
            <a href="#" onclick="window.print(); return false;"
               class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                <i class="bi bi-printer"></i>
                Imprimer
            </a>
            <a href="<?php echo e(route('invoices.pdf', $order)); ?>"
               class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-700">
                <i class="bi bi-file-earmark-pdf"></i>
                Télécharger PDF
            </a>
        </div>
    </div>

    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-5">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-shop text-slate-500"></i>
                        <h5 class="text-sm font-semibold text-slate-900 mb-0">Boutique</h5>
                    </div>
                    <div class="mt-3 text-sm text-slate-700 space-y-1">
                        <div class="font-semibold text-slate-900"><?php echo e($order->shop->company_name ?: $order->shop->name); ?></div>
                        <div class="text-slate-600"><?php echo e($order->shop->street); ?></div>
                        <div class="text-slate-600"><?php echo e($order->shop->city); ?> <?php echo e($order->shop->postal_code); ?></div>
                        <div class="text-slate-600"><?php echo e($order->shop->contact_email); ?></div>
                        <div class="text-slate-600"><?php echo e($order->shop->contact_phone); ?></div>
                    </div>
                </div>

                <div class="rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-5 md:text-right">
                    <div class="flex items-center gap-2 md:justify-end">
                        <i class="bi bi-person text-slate-500"></i>
                        <h5 class="text-sm font-semibold text-slate-900 mb-0">Client</h5>
                    </div>
                    <div class="mt-3 text-sm text-slate-700 space-y-1">
                        <div class="font-semibold text-slate-900"><?php echo e($order->customer_name ?? '—'); ?></div>
                        <div class="text-slate-600"><?php echo e($order->customer_email ?? ''); ?></div>
                        <div class="text-slate-600"><?php echo e($order->customer_phone ?? ''); ?></div>
                        <div class="pt-2 text-slate-600">
                            <?php echo e($order->shipping_address); ?><br>
                            <?php echo e($order->shipping_city); ?> <?php echo e($order->shipping_postal_code); ?><br>
                            <?php echo e($order->shipping_country); ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="my-6 h-px bg-slate-200"></div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-xs uppercase tracking-wide text-slate-500">
                        <tr class="border-b border-slate-200">
                            <th class="py-3 pr-4 text-left font-semibold">Produit</th>
                            <th class="py-3 px-4 text-right font-semibold">Prix</th>
                            <th class="py-3 px-4 text-right font-semibold">Qté</th>
                            <th class="py-3 pl-4 text-right font-semibold">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-slate-50/60">
                                <td class="py-4 pr-4 text-slate-900 font-medium"><?php echo e($item->product_name); ?></td>
                                <td class="py-4 px-4 text-right whitespace-nowrap text-slate-700"><?php echo e(number_format($item->unit_price, 2, ',', ' ')); ?> TND</td>
                                <td class="py-4 px-4 text-right whitespace-nowrap text-slate-700"><?php echo e($item->quantity); ?></td>
                                <td class="py-4 pl-4 text-right whitespace-nowrap font-semibold text-slate-900"><?php echo e(number_format($item->line_total, 2, ',', ' ')); ?> TND</td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <div class="w-full max-w-sm rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4">
                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <span>Sous-total</span>
                        <span class="font-semibold text-slate-900"><?php echo e(number_format($invoice->subtotal ?? 0, 2, ',', ' ')); ?> TND</span>
                    </div>
                    <div class="mt-2 flex items-center justify-between text-sm text-slate-600">
                        <span>Taxes</span>
                        <span class="font-semibold text-slate-900"><?php echo e(number_format($invoice->tax_total ?? 0, 2, ',', ' ')); ?> TND</span>
                    </div>
                    <div class="my-3 h-px bg-slate-200"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-slate-900">Total</span>
                        <span class="text-base font-bold tracking-tight text-slate-900"><?php echo e(number_format($invoice->total ?? 0, 2, ',', ' ')); ?> TND</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/invoices/show.blade.php ENDPATH**/ ?>