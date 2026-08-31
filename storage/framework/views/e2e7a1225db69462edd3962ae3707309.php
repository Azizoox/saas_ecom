

<?php $__env->startSection('title', 'Commandes'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header Section -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl md:text-2xl font-bold text-gray-900 flex items-center gap-3">
            <i class="bi bi-cart-check text-blue-600"></i>
            <span>Toutes les commandes</span>
        </h1>
        <p class="text-gray-500 mt-1">Gérez et suivez vos commandes en temps réel</p>
    </div>
    <a href="<?php echo e(route('orders.create')); ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <i class="bi bi-plus-lg"></i>
        <span>Nouvelle commande</span>
    </a>
</div>

<!-- Filter Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 p-6">
    <form method="GET" action="<?php echo e(route('orders.index')); ?>" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 items-end">
        <!-- Status Filter -->
        <div class="col-span-1">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Statut</label>
            <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white text-gray-900 font-medium">
                <option value="">Tous les statuts</option>
                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status); ?>" <?php if(($filters['status'] ?? '') === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Date From -->
        <div class="col-span-1">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Du</label>
            <input type="date" name="date_from" value="<?php echo e($filters['date_from'] ?? ''); ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white text-gray-900">
        </div>

        <!-- Date To -->
        <div class="col-span-1">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Au</label>
            <input type="date" name="date_to" value="<?php echo e($filters['date_to'] ?? ''); ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white text-gray-900">
        </div>

        <!-- Client -->
        <div class="col-span-1 md:col-span-2 lg:col-span-1">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Client</label>
            <input type="text" name="client" value="<?php echo e($filters['client'] ?? ''); ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white text-gray-900" placeholder="Nom ou email">
        </div>

        <!-- Order Number -->
        <div class="col-span-1">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Commande N°</label>
            <input type="text" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white text-gray-900" placeholder="ORD-...">
        </div>

        <!-- Search Button -->
        <div class="col-span-1 flex gap-2">
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                <i class="bi bi-search"></i>
                <span class="hidden sm:inline">Chercher</span>
            </button>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <?php if($orders->count() > 0): ?>
        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <!-- Table Header -->
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">N° Commande</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Boutique</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-blue-50 transition-colors duration-150 group">
                            <!-- Order Number -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg font-bold text-sm">
                                    <i class="bi bi-bookmark-fill"></i>
                                    <?php echo e($order->order_number); ?>

                                </span>
                            </td>

                            <!-- Shop Name -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full"></div>
                                    <span class="text-sm font-medium text-gray-900"><?php echo e($order->shop->name ?? '—'); ?></span>
                                </div>
                            </td>

                            <!-- Customer Info -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-gray-900"><?php echo e($order->customer_name ?? '—'); ?></span>
                                    <?php if($order->customer_phone): ?>
                                        <span class="text-xs text-gray-500 mt-0.5">
                                            <i class="bi bi-telephone me-1"></i><?php echo e($order->customer_phone); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4">
                                <?php
                                    $statusColor = match($order->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                        'processing' => 'bg-blue-100 text-blue-800 border-blue-300',
                                        'completed' => 'bg-green-100 text-green-800 border-green-300',
                                        'cancelled' => 'bg-red-100 text-red-800 border-red-300',
                                        'shipped' => 'bg-purple-100 text-purple-800 border-purple-300',
                                        default => 'bg-gray-100 text-gray-800 border-gray-300'
                                    };
                                    $statusIcon = match($order->status) {
                                        'pending' => 'bi-hourglass-split',
                                        'processing' => 'bi-arrow-repeat',
                                        'completed' => 'bi-check-circle',
                                        'cancelled' => 'bi-x-circle',
                                        'shipped' => 'bi-box-seam',
                                        default => 'bi-question-circle'
                                    };
                                ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold border <?php echo e($statusColor); ?>">
                                    <i class="bi <?php echo e($statusIcon); ?>"></i>
                                    <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                                </span>
                            </td>

                            <!-- Total Price -->
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-bold text-gray-900"><?php echo e(number_format($order->total ?? 0, 2, ',', ' ')); ?> <span class="text-xs text-gray-500">TND</span></span>
                            </td>

                            <!-- Date -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900"><?php echo e($order->created_at?->format('d/m/Y')); ?></span>
                                    <span class="text-xs text-gray-500"><?php echo e($order->created_at?->format('H:i')); ?></span>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-center">
                                <a href="<?php echo e(route('orders.show', $order)); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-700 transition-all duration-200 transform hover:scale-110 group-hover:shadow-md">
                                    <i class="bi bi-eye-fill text-sm"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-gray-50 border-t border-gray-200 px-6 py-4">
            <?php echo e($orders->links()); ?>

        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-12 px-6">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center mb-4 shadow-lg">
                <i class="bi bi-inbox text-4xl text-blue-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mt-4 mb-2">Aucune commande</h3>
            <p class="text-gray-500 text-center max-w-sm mb-6">Il semble que vous n'ayez pas encore de commandes. Commencez par créer votre première commande.</p>
            <a href="<?php echo e(route('orders.create')); ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <i class="bi bi-plus-lg"></i>
                <span>Créer une commande</span>
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views/orders/index.blade.php ENDPATH**/ ?>