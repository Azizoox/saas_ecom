@extends('layouts.dashboard')

@section('title', 'Nouvelle commande')

@section('content')
<!-- Header Section -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 flex items-center gap-3">
            <i class="bi bi-plus-circle text-blue-600"></i>
            <span>Créer une commande</span>
        </h1>
        <p class="text-gray-500 mt-1">Remplissez les informations du client et ajoutez des produits</p>
    </div>
    <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-900 rounded-lg font-semibold transition-all duration-200">
        <i class="bi bi-arrow-left"></i>
        <span>Retour</span>
    </a>
</div>

<!-- Error Alert -->
@if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
        <div class="flex items-start gap-3">
            <i class="bi bi-exclamation-circle text-red-600 text-xl mt-0.5"></i>
            <div>
                <h3 class="font-bold text-red-900 mb-1">Erreur de validation</h3>
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<form method="POST" action="{{ route('orders.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @csrf

    <!-- Left Column: Client & Shipping Info -->
    <div class="lg:col-span-1">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Client & livraison</strong>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label">Boutique</label>
                        <select name="shop_id" class="form-select" required>
                            @foreach($shops as $shop)
                                <option value="{{ $shop->id }}" @selected(old('shop_id') == $shop->id)>{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Nom client</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" class="form-control">
                    </div>

                    <hr>

                    <div class="mb-2">
                        <label class="form-label">Adresse</label>
                        <textarea name="shipping_address" class="form-control" rows="2">{{ old('shipping_address') }}</textarea>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Ville</label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Code postal</label>
                            <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gouvernorat/État</label>
                            <input type="text" name="shipping_state" value="{{ old('shipping_state') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pays</label>
                            <input type="text" name="shipping_country" value="{{ old('shipping_country') }}" class="form-control">
                        </div>
                    </div>

                    <hr>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Paiement (méthode)</label>
                            <input type="text" name="payment_method" value="{{ old('payment_method') }}" class="form-control" placeholder="Ex: Espèces, Carte...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Paiement (statut)</label>
                            <input type="text" name="payment_status" value="{{ old('payment_status') }}" class="form-control" placeholder="Ex: payé, en attente...">
                        </div>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
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
                                            @foreach($products as $p)
                                                <option value="{{ $p->id }}" data-name="{{ $p->name }}" data-sku="{{ $p->sku }}" data-price="{{ $p->price }}">{{ $p->name }}</option>
                                            @endforeach
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
@endsection

