

<?php $__env->startSection('title', 'Nouvelle commande'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-plus-circle"></i> Créer une commande</h2>
    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <strong>Erreur:</strong> merci de vérifier les champs.
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('orders.store')); ?>">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-lg-5">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Client & livraison</strong>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label">Boutique</label>
                        <select name="shop_id" class="form-select" required>
                            <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($shop->id); ?>" <?php if(old('shop_id') == $shop->id): echo 'selected'; endif; ?>><?php echo e($shop->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Nom client</label>
                        <input type="text" name="customer_name" value="<?php echo e(old('customer_name')); ?>" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="customer_email" value="<?php echo e(old('customer_email')); ?>" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="customer_phone" value="<?php echo e(old('customer_phone')); ?>" class="form-control">
                    </div>

                    <hr>

                    <div class="mb-2">
                        <label class="form-label">Adresse</label>
                        <textarea name="shipping_address" class="form-control" rows="2"><?php echo e(old('shipping_address')); ?></textarea>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Ville</label>
                            <input type="text" name="shipping_city" value="<?php echo e(old('shipping_city')); ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Code postal</label>
                            <input type="text" name="shipping_postal_code" value="<?php echo e(old('shipping_postal_code')); ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gouvernorat/État</label>
                            <input type="text" name="shipping_state" value="<?php echo e(old('shipping_state')); ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pays</label>
                            <input type="text" name="shipping_country" value="<?php echo e(old('shipping_country')); ?>" class="form-control">
                        </div>
                    </div>

                    <hr>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Paiement (méthode)</label>
                            <input type="text" name="payment_method" value="<?php echo e(old('payment_method')); ?>" class="form-control" placeholder="Ex: Espèces, Carte...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Paiement (statut)</label>
                            <input type="text" name="payment_status" value="<?php echo e(old('payment_status')); ?>" class="form-control" placeholder="Ex: payé, en attente...">
                        </div>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes')); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Produits</strong>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-item">
                        <i class="bi bi-plus"></i> Ajouter ligne
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle" id="items-table">
                            <thead>
                                <tr>
                                    <th style="width: 40%">Produit</th>
                                    <th style="width: 15%">Prix</th>
                                    <th style="width: 15%">Qté</th>
                                    <th style="width: 15%">Total</th>
                                    <th style="width: 15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="item-row">
                                    <td>
                                        <select class="form-select product-select">
                                            <option value="">(Saisie manuelle)</option>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($p->id); ?>" data-name="<?php echo e($p->name); ?>" data-sku="<?php echo e($p->sku); ?>" data-price="<?php echo e($p->price); ?>"><?php echo e($p->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <input type="hidden" name="items[0][product_id]" class="product-id">
                                        <input type="text" name="items[0][product_name]" class="form-control mt-2 product-name" placeholder="Nom du produit" required>
                                        <input type="text" name="items[0][sku]" class="form-control mt-2 product-sku" placeholder="SKU">
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" min="0" name="items[0][unit_price]" class="form-control unit-price" value="0">
                                    </td>
                                    <td>
                                        <input type="number" min="1" name="items[0][quantity]" class="form-control quantity" value="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control line-total" value="0.00" readonly>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-item" disabled>
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div style="min-width: 250px;">
                            <div class="d-flex justify-content-between">
                                <span>Sous-total</span>
                                <strong id="subtotal">0.00</strong>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <span>Total</span>
                                <strong id="grand-total">0.00</strong>
                            </div>
                            <small class="text-muted">Calcul automatique (hors livraison/remise pour l’instant).</small>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle"></i> Créer la commande
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function recalcTotals() {
        let subtotal = 0;
        document.querySelectorAll('#items-table tbody tr').forEach((row) => {
            const price = parseFloat(row.querySelector('.unit-price').value || '0');
            const qty = parseInt(row.querySelector('.quantity').value || '0', 10);
            const line = price * qty;
            row.querySelector('.line-total').value = line.toFixed(2);
            subtotal += line;
        });
        document.getElementById('subtotal').innerText = subtotal.toFixed(2);
        document.getElementById('grand-total').innerText = subtotal.toFixed(2);
    }

    function renumberItems() {
        document.querySelectorAll('#items-table tbody tr').forEach((row, idx) => {
            row.querySelectorAll('input, select').forEach((el) => {
                if (!el.name) return;
                el.name = el.name.replace(/items\[\d+\]/, 'items[' + idx + ']');
            });
        });
        // disable remove if only one row
        const rows = document.querySelectorAll('#items-table tbody tr');
        rows.forEach((r) => r.querySelector('.remove-item').disabled = rows.length === 1);
    }

    document.addEventListener('input', (e) => {
        if (e.target.classList.contains('unit-price') || e.target.classList.contains('quantity')) {
            recalcTotals();
        }
        if (e.target.classList.contains('product-name') || e.target.classList.contains('product-sku')) {
            // no-op
        }
    });

    document.addEventListener('change', (e) => {
        if (e.target.classList.contains('product-select')) {
            const row = e.target.closest('tr');
            const selected = e.target.options[e.target.selectedIndex];
            const id = e.target.value || '';
            row.querySelector('.product-id').value = id;
            if (id) {
                row.querySelector('.product-name').value = selected.dataset.name || '';
                row.querySelector('.product-sku').value = selected.dataset.sku || '';
                row.querySelector('.unit-price').value = selected.dataset.price || '0';
            }
            recalcTotals();
        }
    });

    document.getElementById('add-item').addEventListener('click', () => {
        const tbody = document.querySelector('#items-table tbody');
        const first = tbody.querySelector('tr');
        const clone = first.cloneNode(true);

        clone.querySelector('.product-select').value = '';
        clone.querySelector('.product-id').value = '';
        clone.querySelector('.product-name').value = '';
        clone.querySelector('.product-sku').value = '';
        clone.querySelector('.unit-price').value = '0';
        clone.querySelector('.quantity').value = '1';
        clone.querySelector('.line-total').value = '0.00';

        tbody.appendChild(clone);
        renumberItems();
        recalcTotals();
    });

    document.addEventListener('click', (e) => {
        if (e.target.closest('.remove-item')) {
            const btn = e.target.closest('.remove-item');
            const row = btn.closest('tr');
            const tbody = row.parentElement;
            if (tbody.querySelectorAll('tr').length > 1) {
                row.remove();
                renumberItems();
                recalcTotals();
            }
        }
    });

    // init
    renumberItems();
    recalcTotals();
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahach\OneDrive\Bureau\shoopino\resources\views\orders\create.blade.php ENDPATH**/ ?>