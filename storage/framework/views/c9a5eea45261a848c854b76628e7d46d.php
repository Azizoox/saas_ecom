

<?php $__env->startSection('title', 'Détail commande'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $status = strtolower((string) ($order->status ?? ''));
    $statusStyles = [
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'paid' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'processing' => 'bg-blue-50 text-blue-700 ring-blue-200',
        'shipped' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
        'delivered' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'cancelled' => 'bg-rose-50 text-rose-700 ring-rose-200',
        'canceled' => 'bg-rose-50 text-rose-700 ring-rose-200',
        'refunded' => 'bg-slate-50 text-slate-700 ring-slate-200',
    ];
    $statusPill = $statusStyles[$status] ?? 'bg-slate-50 text-slate-700 ring-slate-200';

    $paymentStatus = strtolower((string) ($order->payment_status ?? ''));
    $paymentStyles = [
        'paid' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'unpaid' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'failed' => 'bg-rose-50 text-rose-700 ring-rose-200',
        'refunded' => 'bg-slate-50 text-slate-700 ring-slate-200',
    ];
    $paymentPill = $paymentStyles[$paymentStatus] ?? 'bg-slate-50 text-slate-700 ring-slate-200';

    $paymentStatus = strtolower((string) ($order->payment_status ?? ''));
    $paymentStyles = [
        'paid' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'unpaid' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'failed' => 'bg-rose-50 text-rose-700 ring-rose-200',
        'refunded' => 'bg-slate-50 text-slate-700 ring-slate-200',
    ];
    $paymentPill = $paymentStyles[$paymentStatus] ?? 'bg-slate-50 text-slate-700 ring-slate-200';
?>

<div class="mx-auto max-w-7xl">
    <div class="mb-6 rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-600 to-slate-900 p-6 text-white shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
            <div class="min-w-0">
                <div class="flex items-center gap-3">
                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-white/10 ring-1 ring-inset ring-white/15">
                        <i class="bi bi-receipt text-2xl"></i>
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-2xl md:text-3xl font-bold tracking-tight truncate mb-0">
                            <?php echo e($order->order_number); ?>

                        </h2>
                        <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-indigo-100">
                            <span><i class="bi bi-calendar3 me-1"></i> <?php echo e($order->created_at?->format('d/m/Y H:i')); ?></span>
                            <span class="hidden sm:inline">•</span>
                            <span><i class="bi bi-shop me-1"></i> <?php echo e($order->shop->name ?? '—'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold ring-1 ring-inset ring-white/15">
                        <i class="bi bi-activity"></i>
                        Statut: <span class="font-bold"><?php echo e(ucfirst($order->status)); ?></span>
                    </span>
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold ring-1 ring-inset ring-white/15">
                        <i class="bi bi-credit-card"></i>
                        Paiement: <span class="font-bold"><?php echo e($order->payment_status ?? '—'); ?></span>
                    </span>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="<?php echo e(route('orders.index')); ?>"
                   class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm hover:bg-indigo-50">
                    <i class="bi bi-arrow-left"></i>
                    Retour
                </a>
               
                <a href="#" onclick="window.print(); return false;"
                   class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-white/20 hover:bg-white/15">
                    <i class="bi bi-printer"></i>
                    Imprimer
                </a>
            </div>
        </div>
    </div>

  

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8 space-y-6">
            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-bag text-slate-500"></i>
                        <p class="text-sm font-semibold text-slate-900 mb-0">Produits</p>
                    </div>
                    <span class="text-xs text-slate-500"><?php echo e($order->items->count()); ?> article(s)</span>
                </div>

                <div class="p-5">
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
                                        <td class="py-4 pr-4 align-top">
                                            <div class="font-semibold text-slate-900"><?php echo e($item->product_name); ?></div>
                                            <?php if($item->sku): ?>
                                                <div class="mt-1 text-xs text-slate-500">SKU: <?php echo e($item->sku); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 px-4 text-right whitespace-nowrap text-slate-700">
                                            <?php echo e(number_format($item->unit_price, 2, ',', ' ')); ?> TND
                                        </td>
                                        <td class="py-4 px-4 text-right whitespace-nowrap text-slate-700">
                                            <?php echo e($item->quantity); ?>

                                        </td>
                                        <td class="py-4 pl-4 text-right whitespace-nowrap font-semibold text-slate-900">
                                            <?php echo e(number_format($item->line_total, 2, ',', ' ')); ?> TND
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <div class="w-full max-w-sm rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4">
                            <div class="flex items-center justify-between text-sm text-slate-600">
                                <span>Sous-total</span>
                                <span class="font-semibold text-slate-900"><?php echo e(number_format($order->subtotal ?? 0, 2, ',', ' ')); ?> TND</span>
                            </div>
                            <div class="mt-2 flex items-center justify-between text-sm text-slate-600">
                                <span>Livraison</span>
                                <span class="font-semibold text-slate-900"><?php echo e(number_format($order->shipping_total ?? 0, 2, ',', ' ')); ?> TND</span>
                            </div>
                            <div class="mt-2 flex items-center justify-between text-sm text-slate-600">
                                <span>Remise</span>
                                <span class="font-semibold text-slate-900">-<?php echo e(number_format($order->discount_total ?? 0, 2, ',', ' ')); ?> TND</span>
                            </div>
                            <div class="my-3 h-px bg-slate-200"></div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold text-slate-900">Total</span>
                                <span class="text-base font-bold tracking-tight text-slate-900"><?php echo e(number_format($order->total ?? 0, 2, ',', ' ')); ?> TND</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="px-5 py-4 border-b border-slate-200">
                    <p class="text-sm font-semibold text-slate-900 mb-0"><i class="bi bi-credit-card me-2 text-slate-500"></i>Paiement</p>
                </div>
                <div class="p-5 space-y-2 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-500">Méthode</span>
                        <span class="font-semibold text-slate-900"><?php echo e($order->payment_method ?? '—'); ?></span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-500">Statut</span>
                        <span class="font-semibold text-slate-900"><?php echo e($order->payment_status ?? '—'); ?></span>
                    </div>
                </div>
            </div>
                <!-- <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-clock-history text-slate-500"></i>
                        <p class="text-sm font-semibold text-slate-900 mb-0">Historique des statuts</p>
                    </div>
                </div> -->
                <!-- <div class="p-5">
                    <?php if($order->statusHistories->count()): ?>
                        <ol class="relative space-y-3">
                            <?php $__currentLoopData = $order->statusHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="relative rounded-2xl bg-white ring-1 ring-inset ring-slate-200 p-4">
                                    <div class="flex gap-3">
                                        <div class="mt-0.5 grid h-10 w-10 place-items-center rounded-2xl bg-slate-50 text-slate-700 ring-1 ring-inset ring-slate-200">
                                            <i class="bi bi-check2-circle"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-wrap items-center justify-between gap-2">
                                                <div class="text-sm font-semibold text-slate-900">
                                                    <?php echo e(ucfirst($h->to_status)); ?>

                                                    <?php if($h->from_status): ?>
                                                        <span class="text-xs font-medium text-slate-500">(depuis <?php echo e($h->from_status); ?>)</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-xs text-slate-500">
                                                    <i class="bi bi-clock me-1"></i><?php echo e($h->created_at?->format('d/m/Y H:i')); ?>

                                                </div>
                                            </div>
                                            <?php if($h->note): ?>
                                                <div class="mt-2 rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 px-3 py-2 text-sm text-slate-700">
                                                    <?php echo e($h->note); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if($h->changedBy): ?>
                                                <div class="mt-2 text-xs text-slate-500">
                                                    <i class="bi bi-person me-1"></i><?php echo e($h->changedBy->email); ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ol>
                    <?php else: ?>
                        <div class="rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4 text-sm text-slate-600">
                            Aucun historique.
                        </div>
                    <?php endif; ?>
                </div> -->
            </div>
        </div>

        <aside class="lg:col-span-4 space-y-6">
            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="px-5 py-4 border-b border-slate-200">
                    <p class="text-sm font-semibold text-slate-900 mb-0"><i class="bi bi-person me-2 text-slate-500"></i>Client</p>
                </div>
                <div class="p-5 space-y-2 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-500">Nom</span>
                        <span class="font-semibold text-slate-900"><?php echo e($order->customer_name ?? '—'); ?></span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-500">Email</span>
                        <span class="font-semibold text-slate-900"><?php echo e($order->customer_email ?? '—'); ?></span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-500">Téléphone</span>
                        <span class="font-semibold text-slate-900"><?php echo e($order->customer_phone ?? '—'); ?></span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="px-5 py-4 border-b border-slate-200">
                    <p class="text-sm font-semibold text-slate-900 mb-0"><i class="bi bi-truck me-2 text-slate-500"></i>Livraison</p>
                </div>
                <div class="p-5 text-sm text-slate-700 space-y-2">
                    <div class="text-slate-500 text-xs uppercase tracking-wide">Adresse</div>
                    <div class="font-medium text-slate-900 whitespace-pre-line"><?php echo e($order->shipping_address ?? '—'); ?></div>
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <div>
                            <div class="text-slate-500 text-xs">Ville</div>
                            <div class="font-semibold text-slate-900"><?php echo e($order->shipping_city ?? '—'); ?></div>
                        </div>
                        <div>
                            <div class="text-slate-500 text-xs">Code postal</div>
                            <div class="font-semibold text-slate-900"><?php echo e($order->shipping_postal_code ?? '—'); ?></div>
                        </div>
                        <div>
                            <div class="text-slate-500 text-xs">État</div>
                            <div class="font-semibold text-slate-900"><?php echo e($order->shipping_state ?? '—'); ?></div>
                        </div>
                        <div>
                            <div class="text-slate-500 text-xs">Pays</div>
                            <div class="font-semibold text-slate-900"><?php echo e($order->shipping_country ?? '—'); ?></div>
                        </div>
                    </div>
                </div>
            </div>

           

            <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200">
                    <p class="text-sm font-semibold text-slate-900 mb-0"><i class="bi bi-lightning-charge me-2 text-slate-500"></i>Actions</p>
                </div>
                <div class="p-5 space-y-4">
                    <form method="POST" action="<?php echo e(route('orders.status', $order)); ?>" class="space-y-3">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Modifier statut</label>
                            <select name="status" required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s); ?>" <?php if($order->status === $s): echo 'selected'; endif; ?>><?php echo e(ucfirst($s)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <input type="text" name="note" placeholder="Note (optionnel)"
                                   class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="bi bi-arrow-repeat"></i>
                            Mettre à jour
                        </button>
                    </form>

                    <div class="grid grid-cols-1 gap-2">
                        <form method="POST" action="<?php echo e(route('invoices.generate', $order)); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-indigo-700 shadow-sm ring-1 ring-inset ring-indigo-200 hover:bg-indigo-50"
                                    type="submit">
                                <i class="bi bi-receipt"></i>
                                Générer facture
                            </button>
                        </form>

                        <?php if($order->invoice): ?>
                            <a class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-200 hover:bg-slate-50"
                               href="<?php echo e(route('invoices.show', $order)); ?>">
                                <i class="bi bi-eye"></i>
                                Voir facture
                            </a>
                            <a class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-rose-700"
                               href="<?php echo e(route('invoices.pdf', $order)); ?>">
                                <i class="bi bi-file-earmark-pdf"></i>
                                Télécharger PDF
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/orders/show.blade.php ENDPATH**/ ?>