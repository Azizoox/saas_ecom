@extends('shop.layouts.app')

@section('title', 'Panier - ' . ($shop->name ?? 'Ma Boutique'))

@section('content')

<style>
    .cart-wrapper { max-width: 1100px; margin: 0 auto; padding: 2.5rem 1rem; }

    .cart-title {
        font-size: 1.9rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 2rem;
        letter-spacing: -0.03em;
    }

    /* ── Cart Item ── */
    .cart-item {
        display: grid;
        grid-template-columns: 90px 1fr auto auto;
        gap: 1.2rem;
        align-items: center;
        padding: 1.2rem 0;
        border-bottom: 1px solid #f0f0f0;
        transition: opacity 0.35s ease, transform 0.35s ease;
    }

    .cart-item.removing {
        opacity: 0;
        transform: translateX(30px);
        pointer-events: none;
    }

    .cart-item img,
    .cart-item .img-placeholder {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 12px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #bbb;
        font-size: 1.6rem;
    }

    .item-name {
        font-weight: 600;
        font-size: 1rem;
        color: #111;
        margin-bottom: 0.2rem;
    }

    .item-desc {
        font-size: 0.82rem;
        color: #888;
        margin-bottom: 0.35rem;
        line-height: 1.4;
    }

    .item-unit-price {
        font-size: 0.8rem;
        color: #aaa;
    }

    /* ── Quantity Controls ── */
    .qty-ctrl {
        display: flex;
        align-items: center;
        border: 1.5px solid #e5e5e5;
        border-radius: 10px;
        overflow: hidden;
        width: fit-content;
    }

    .qty-btn {
        background: none;
        border: none;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #555;
        font-size: 1.1rem;
        transition: background 0.2s, color 0.2s;
    }

    .qty-btn:hover:not(:disabled) { background: #f5f5f5; color: #111; }
    .qty-btn:disabled { opacity: 0.3; cursor: not-allowed; }

    .qty-input {
        width: 38px;
        text-align: center;
        border: none;
        border-left: 1.5px solid #e5e5e5;
        border-right: 1.5px solid #e5e5e5;
        font-size: 0.9rem;
        font-weight: 600;
        color: #111;
        background: #fff;
        outline: none;
        padding: 0;
        height: 36px;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-inner-spin-button,
    .qty-input::-webkit-outer-spin-button { -webkit-appearance: none; }

    /* ── Item Total + Remove ── */
    .item-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.5rem;
        min-width: 90px;
    }

    .item-total {
        font-weight: 700;
        font-size: 1.05rem;
        color: #111;
    }

    .btn-remove {
        background: none;
        border: none;
        color: #ccc;
        cursor: pointer;
        font-size: 1rem;
        padding: 0;
        transition: color 0.2s;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.78rem;
    }
    .btn-remove:hover { color: #e53e3e; }

    /* ── Loading spinner on qty ── */
    .qty-ctrl.loading {
        pointer-events: none;
        opacity: 0.5;
    }

    /* ── Summary Card ── */
    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 2.5rem;
        align-items: start;
    }

    .summary-card {
        background: #fafafa;
        border: 1.5px solid #efefef;
        border-radius: 18px;
        padding: 1.8rem;
        position: sticky;
        top: 2rem;
    }

    .summary-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 1.4rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.92rem;
        color: #555;
        margin-bottom: 0.8rem;
    }

    .summary-row.total {
        font-size: 1.15rem;
        font-weight: 700;
        color: #111;
        padding-top: 1rem;
        border-top: 1.5px solid #e8e8e8;
        margin-top: 0.5rem;
    }

    .free-badge {
        background: #dcfce7;
        color: #16a34a;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
    }

    .checkout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.9rem;
        background: #f15a24;
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        margin-top: 1.3rem;
        transition: background 0.2s, transform 0.15s;
    }
    .checkout-btn:hover { background:rgb(209, 72, 23); color: #fff; transform: translateY(-1px); }

    .btn-clear-cart {
        background: none;
        border: 1.5px solid #fecaca;
        color: #e53e3e;
        border-radius: 10px;
        padding: 0.5rem 1.2rem;
        font-size: 0.83rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 1.5rem;
        transition: all 0.2s;
    }
    .btn-clear-cart:hover { background: #fff5f5; }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 5rem 1rem;
    }
    .empty-icon {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    .empty-state h3 { font-weight: 700; color: #111; margin-bottom: 0.5rem; }
    .empty-state p { color: #888; margin-bottom: 1.5rem; }
    .btn-shop {
        background: #111;
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.8rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: background 0.2s;
    }
    .btn-shop:hover { background: #333; color: #fff; }

    /* ── Toast ── */
    .toast-container-custom {
        position: fixed;
        bottom: 1.5rem;
        right: 1.5rem;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .toast-msg {
        background: #111;
        color: #fff;
        padding: 0.75rem 1.2rem;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: toastIn 0.3s ease, toastOut 0.3s ease 2.5s forwards;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    .toast-msg.success { background: #166534; }
    .toast-msg.error   { background: #991b1b; }

    @keyframes toastIn  { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    @keyframes toastOut { from { opacity:1; } to { opacity:0; } }

    /* ── Modal ── */
    .modal-content { border-radius: 18px !important; border: none !important; }
    .modal-icon-wrap {
        width: 72px; height: 72px; margin: 0 auto 1rem;
        background: #fee2e2;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; color: #dc2626;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .cart-layout { grid-template-columns: 1fr; }
        .cart-item   { grid-template-columns: 72px 1fr; grid-template-rows: auto auto; }
        .item-right  { flex-direction: row; align-items: center; grid-column: 1/-1; }
        .summary-card { position: static; }
    }
</style>

<div class="cart-wrapper">
    <h1 class="cart-title">Votre panier</h1>

    @if($cartItems && $cartItems->count() > 0)

    <div class="cart-layout">

        {{-- ── LEFT : items ── --}}
        <div>
            <div id="cart-items-list">
                @foreach($cartItems as $item)
                <div class="cart-item" id="cart-item-{{ $item->product_id }}" data-price="{{ $item->product->price }}">

                    {{-- Image --}}
                    @if($item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                    @else
                        <div class="img-placeholder"><i class="bi bi-image"></i></div>
                    @endif

                    {{-- Info --}}
                    <div>
                        <div class="item-name">{{ $item->product->name }}</div>
                        <div class="item-desc">{!! Str::limit(strip_tags($item->product->short_description ?? $item->product->description ?? ''), 80) !!}</div>
                        <div class="item-unit-price">{{ number_format($item->product->price, 2, ',', ' ') }} TND / unité</div>
                    </div>

                    {{-- Quantity --}}
                    <div class="qty-ctrl" id="qty-ctrl-{{ $item->product_id }}">
                        <button class="qty-btn btn-decrease"
                                data-pid="{{ $item->product_id }}"
                                data-min="1"
                                {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                            <i class="bi bi-dash"></i>
                        </button>
                        <input  class="qty-input"
                                type="number"
                                value="{{ $item->quantity }}"
                                min="1"
                                max="{{ $item->product->stock }}"
                                data-pid="{{ $item->product_id }}">
                        <button class="qty-btn btn-increase"
                                data-pid="{{ $item->product_id }}"
                                data-max="{{ $item->product->stock }}"
                                {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>

                    {{-- Total + Remove --}}
                    <div class="item-right">
                        <span class="item-total" id="item-total-{{ $item->product_id }}">
                            {{ number_format($item->product->price * $item->quantity, 2, ',', ' ') }} TND
                        </span>
                        <button class="btn-remove" data-pid="{{ $item->product_id }}">
                            <i class="bi bi-trash"></i> Retirer
                        </button>
                    </div>

                </div>
                @endforeach
            </div>

            <button class="btn-clear-cart" id="openClearModal">
                <i class="bi bi-x-circle"></i> Vider le panier
            </button>
        </div>

        {{-- ── RIGHT : summary ── --}}
        <div>
            <div class="summary-card">
                <div class="summary-title">Récapitulatif</div>

                <div class="summary-row">
                    <span>Sous-total</span>
                    <strong id="summary-subtotal">{{ number_format($totalPrice, 2, ',', ' ') }} TND</strong>
                </div>
                <div class="summary-row">
                    <span>Livraison</span>
                    <span class="free-badge">Gratuite</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span id="summary-total">{{ number_format($totalPrice, 2, ',', ' ') }} TND</span>
                </div>

                <a href="{{ route('shop.checkout', ['subdomain' => $shop->subdomain ?? request()->route('subdomain', '')]) }}"
                   class="checkout-btn">
                    <i class="bi bi-credit-card"></i> Commander
                </a>
            </div>
        </div>

    </div>

    @else

    <div class="empty-state" id="empty-state">
        <div class="empty-icon"><i class="bi bi-cart-x"></i></div>
        <h3>Votre panier est vide</h3>
        <p>Commencez par ajouter des produits à votre panier</p>
        <a href="{{ route('shop.index', ['subdomain' => $shop->subdomain ?? '']) }}" class="btn-shop">
            <i class="bi bi-shop"></i> Explorer la boutique
        </a>
    </div>

    @endif
</div>

{{-- ── Toast container ── --}}
<div class="toast-container-custom" id="toast-container"></div>

{{-- ── Clear Cart Modal ── --}}
<div class="modal fade" id="clearCartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content p-4 text-center">
            <button type="button" class="btn-close ms-auto mb-2" data-bs-dismiss="modal"></button>
            <div class="modal-icon-wrap"><i class="bi bi-cart-x"></i></div>
            <h5 class="fw-bold mb-1">Vider le panier ?</h5>
            <p class="text-muted small mb-4">Tous vos articles seront supprimés. Cette action est irréversible.</p>
            <div class="d-flex gap-2 justify-content-center">
                <button class="btn btn-light px-4 fw-semibold" data-bs-dismiss="modal">Annuler</button>
                <button class="btn btn-danger px-4 fw-semibold" id="confirmClearCart">
                    <i class="bi bi-trash me-1"></i>Vider
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    /* ───────────── CONFIG ───────────── */
    const ROUTES = {
        update : '{{ route("shop.cart.update", ["subdomain" => $shop->subdomain]) }}',
        remove : '{{ route("shop.cart.remove", ["subdomain" => $shop->subdomain]) }}',
        clear  : '{{ route("shop.cart.clear",  ["subdomain" => $shop->subdomain]) }}',
        shop   : '{{ route("shop.index",        ["subdomain" => $shop->subdomain ?? ""]) }}'
    };
    const CSRF = () => document.querySelector('meta[name="csrf-token"]').content;

    /* ───────────── HELPERS ───────────── */

    function toast(msg, type = 'success') {
        const el = document.createElement('div');
        el.className = `toast-msg ${type}`;
        el.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i> ${msg}`;
        document.getElementById('toast-container').appendChild(el);
        setTimeout(() => el.remove(), 3000);
    }

    function fmtPrice(val) {
        return val.toLocaleString('fr-TN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' TND';
    }

    function updateNavBadge(count) {
        document.querySelectorAll('.badge.bg-danger.ms-1').forEach(b => b.textContent = count);
    }

    function recalcSummary() {
        let total = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const price = parseFloat(item.dataset.price);
            const qty   = parseInt(item.querySelector('.qty-input').value);
            total += price * qty;
        });
        const fmt = fmtPrice(total);
        document.getElementById('summary-subtotal').textContent = fmt;
        document.getElementById('summary-total').textContent    = fmt;
    }

    function showEmptyState() {
        // Replace entire cart layout with empty state
        const wrapper = document.querySelector('.cart-wrapper');
        wrapper.innerHTML = `
            <h1 class="cart-title">Votre panier</h1>
            <div class="empty-state">
                <div class="empty-icon"><i class="bi bi-cart-x"></i></div>
                <h3>Votre panier est vide</h3>
                <p>Commencez par ajouter des produits à votre panier</p>
                <a href="${ROUTES.shop}" class="btn-shop">
                    <i class="bi bi-shop"></i> Explorer la boutique
                </a>
            </div>`;
    }

    /* ───────────── API ───────────── */

    async function apiPost(url, body = {}) {
        const res = await fetch(url, {
            method : 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            body   : JSON.stringify(body)
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    }

    /* ───────────── UPDATE QTY ───────────── */

    async function updateQuantity(pid, qty) {
        const ctrl  = document.getElementById(`qty-ctrl-${pid}`);
        const input = ctrl.querySelector('.qty-input');
        const btnM  = ctrl.querySelector('.btn-decrease');
        const btnP  = ctrl.querySelector('.btn-increase');

        ctrl.classList.add('loading');

        try {
            const data = await apiPost(ROUTES.update, { product_id: pid, quantity: qty });

            if (!data.success) { toast(data.message ?? 'Erreur lors de la mise à jour', 'error'); return; }

            // Update DOM
            const price = parseFloat(document.getElementById(`cart-item-${pid}`).dataset.price);
            document.getElementById(`item-total-${pid}`).textContent = fmtPrice(price * qty);

            // Toggle button states
            btnM.disabled = qty <= parseInt(input.min);
            btnP.disabled = qty >= parseInt(input.max);

            recalcSummary();
            updateNavBadge(data.cart_count);
            toast('Quantité mise à jour');

        } catch (e) {
            toast('Erreur réseau, veuillez réessayer', 'error');
            console.error(e);
        } finally {
            ctrl.classList.remove('loading');
        }
    }

    /* ───────────── REMOVE ITEM ───────────── */

    async function removeItem(pid) {
        const itemEl = document.getElementById(`cart-item-${pid}`);
        itemEl.classList.add('removing');

        try {
            const data = await apiPost(ROUTES.remove, { product_id: pid });

            if (!data.success) {
                itemEl.classList.remove('removing');
                toast(data.message ?? 'Impossible de retirer cet article', 'error');
                return;
            }

            // Wait for animation then remove
            setTimeout(() => {
                itemEl.remove();
                recalcSummary();
                updateNavBadge(data.cart_count);
                toast('Article retiré du panier');

                if (document.querySelectorAll('.cart-item').length === 0) showEmptyState();
            }, 350);

        } catch (e) {
            itemEl.classList.remove('removing');
            toast('Erreur réseau, veuillez réessayer', 'error');
            console.error(e);
        }
    }

    /* ───────────── CLEAR CART ───────────── */

    async function clearCart() {
        try {
            const data = await apiPost(ROUTES.clear);

            if (!data.success) { toast(data.message ?? 'Impossible de vider le panier', 'error'); return; }

            // Animate all items out
            document.querySelectorAll('.cart-item').forEach((el, i) => {
                setTimeout(() => el.classList.add('removing'), i * 60);
            });

            setTimeout(() => {
                updateNavBadge(data.cart_count);
                showEmptyState();
            }, document.querySelectorAll('.cart-item').length * 60 + 400);

        } catch (e) {
            toast('Erreur réseau, veuillez réessayer', 'error');
            console.error(e);
        }
    }

    /* ───────────── EVENT DELEGATION ───────────── */

    document.getElementById('cart-items-list')?.addEventListener('click', function (e) {
        const btnInc = e.target.closest('.btn-increase');
        const btnDec = e.target.closest('.btn-decrease');
        const btnRem = e.target.closest('.btn-remove');

        if (btnInc) {
            const pid   = btnInc.dataset.pid;
            const input = document.querySelector(`.qty-input[data-pid="${pid}"]`);
            const val   = parseInt(input.value);
            const max   = parseInt(input.max);
            if (val < max) { input.value = val + 1; updateQuantity(pid, val + 1); }
        }

        if (btnDec) {
            const pid   = btnDec.dataset.pid;
            const input = document.querySelector(`.qty-input[data-pid="${pid}"]`);
            const val   = parseInt(input.value);
            const min   = parseInt(input.min);
            if (val > min) { input.value = val - 1; updateQuantity(pid, val - 1); }
        }

        if (btnRem) {
            removeItem(btnRem.dataset.pid);
        }
    });

    document.getElementById('cart-items-list')?.addEventListener('change', function (e) {
        if (!e.target.classList.contains('qty-input')) return;
        const pid = e.target.dataset.pid;
        let val   = parseInt(e.target.value);
        const min = parseInt(e.target.min);
        const max = parseInt(e.target.max);
        val = Math.min(max, Math.max(min, val || min));
        e.target.value = val;
        updateQuantity(pid, val);
    });

    /* ── Clear modal ── */
    document.getElementById('openClearModal')?.addEventListener('click', () => {
        new bootstrap.Modal(document.getElementById('clearCartModal')).show();
    });

    const confirmBtn = document.getElementById('confirmClearCart');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', () => {
            bootstrap.Modal.getInstance(document.getElementById('clearCartModal'))?.hide();
            clearCart();
        });
    }

})();
</script>

@endsection