<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        $shops = $user->shops;

        $query = Order::query()
            ->whereIn('shop_id', $shops->pluck('id'))
            ->with('shop')
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        if ($request->filled('client')) {
            $client = $request->string('client')->toString();
            $query->where(function ($q) use ($client) {
                $q->where('customer_name', 'like', "%{$client}%")
                    ->orWhere('customer_email', 'like', "%{$client}%")
                    ->orWhere('customer_phone', 'like', "%{$client}%");
            });
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where('order_number', 'like', "%{$q}%");
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('orders.index', [
            'orders' => $orders,
            'shops' => $shops,
            'statuses' => Order::allowedStatuses(),
            'filters' => $request->only(['status', 'date_from', 'date_to', 'client', 'q']),
        ]);
    }

    public function create(): View
    {
        $user = auth()->user();
        $shops = $user->shops;

        $products = Product::whereIn('shop_id', $shops->pluck('id'))
            ->orderBy('name')
            ->get();

        return view('orders.create', [
            'shops' => $shops,
            'products' => $products,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'shop_id' => ['required', 'exists:shops,id', function ($attribute, $value, $fail) use ($user) {
                if (!$user->shops->contains('id', $value)) {
                    $fail('Vous ne possédez pas cette boutique.');
                }
            }],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:50'],

            'shipping_address' => ['nullable', 'string'],
            'shipping_city' => ['nullable', 'string', 'max:255'],
            'shipping_postal_code' => ['nullable', 'string', 'max:50'],
            'shipping_state' => ['nullable', 'string', 'max:255'],
            'shipping_country' => ['nullable', 'string', 'max:255'],

            'payment_method' => ['nullable', 'string', 'max:255'],
            'payment_status' => ['nullable', 'string', 'max:255'],

            'notes' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['nullable', 'exists:products,id'],
            'items.*.product_name' => ['required', 'string', 'max:255'],
            'items.*.sku' => ['nullable', 'string', 'max:255'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $order = DB::transaction(function () use ($validated) {
            /** @var Order $order */
            $order = Order::create([
                'shop_id' => $validated['shop_id'],
                'customer_name' => $validated['customer_name'] ?? null,
                'customer_email' => $validated['customer_email'] ?? null,
                'customer_phone' => $validated['customer_phone'] ?? null,
                'shipping_address' => $validated['shipping_address'] ?? null,
                'shipping_city' => $validated['shipping_city'] ?? null,
                'shipping_postal_code' => $validated['shipping_postal_code'] ?? null,
                'shipping_state' => $validated['shipping_state'] ?? null,
                'shipping_country' => $validated['shipping_country'] ?? null,
                'payment_method' => $validated['payment_method'] ?? null,
                'payment_status' => $validated['payment_status'] ?? null,
                'status' => Order::STATUS_NEW,
                'shipping_total' => 0,
                'discount_total' => 0,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'product_name' => $item['product_name'],
                    'sku' => $item['sku'] ?? null,
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    // line_total is auto-calculated in model saving()
                    'line_total' => 0,
                ]);
            }

            $order->recalculateTotals();
            $order->save();

            $order->statusHistories()->create([
                'from_status' => null,
                'to_status' => $order->status,
                'changed_by_user_id' => auth()->id(),
                'note' => 'Création de la commande',
            ]);

            return $order;
        });

        return redirect()->route('orders.show', $order)
            ->with('success', 'Commande créée avec succès !');
    }

    public function show(Order $order): View
    {
        $user = auth()->user();
        if (!$user->shops->contains('id', $order->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        $order->load(['shop', 'items', 'statusHistories.changedBy', 'invoice', 'pickup', 'packing', 'returnRequest']);

        return view('orders.show', [
            'order' => $order,
            'statuses' => Order::allowedStatuses(),
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->shops->contains('id', $order->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(Order::allowedStatuses())],
            'note' => ['nullable', 'string'],
        ]);

        if ($validated['status'] === $order->status) {
            return back()->with('success', 'Statut inchangé.');
        }

        DB::transaction(function () use ($order, $validated) {
            $from = $order->status;
            $order->status = $validated['status'];
            $order->save();

            $order->statusHistories()->create([
                'from_status' => $from,
                'to_status' => $validated['status'],
                'changed_by_user_id' => auth()->id(),
                'note' => $validated['note'] ?? null,
            ]);
        });

        return back()->with('success', 'Statut mis à jour.');
    }
}

