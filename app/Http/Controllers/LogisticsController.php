<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderPacking;
use App\Models\OrderPickup;
use App\Models\OrderReturn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LogisticsController extends Controller
{
    public function pickups(): View
    {
        $user = auth()->user();
        $shops = $user->shops;

        $orders = Order::query()
            ->whereIn('shop_id', $shops->pluck('id'))
            ->with(['shop', 'pickup'])
            ->where(function ($q) {
                $q->whereDoesntHave('pickup')
                    ->orWhereHas('pickup', function ($qq) {
                        $qq->where('status', 'pending');
                    });
            })
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('logistics.pickups', ['orders' => $orders]);
    }

    public function markPickedUp(Order $order): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->shops->contains('id', $order->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        DB::transaction(function () use ($order) {
            /** @var OrderPickup $pickup */
            $pickup = $order->pickup ?: $order->pickup()->create([
                'shop_id' => $order->shop_id,
                'status' => 'pending',
            ]);

            $pickup->update([
                'status' => 'picked_up',
                'picked_up_at' => now(),
            ]);
        });

        return back()->with('success', 'Statut ramassage mis à jour.');
    }

    public function pickupSlip(): View
    {
        $user = auth()->user();
        $shops = $user->shops;

        $orders = Order::query()
            ->whereIn('shop_id', $shops->pluck('id'))
            ->with(['shop', 'pickup'])
            ->where(function ($q) {
                $q->whereDoesntHave('pickup')
                    ->orWhereHas('pickup', function ($qq) {
                        $qq->where('status', 'pending');
                    });
            })
            ->orderBy('shop_id')
            ->orderBy('created_at')
            ->get();

        return view('logistics.pickup_slip', ['orders' => $orders]);
    }

    public function packings(): View
    {
        $user = auth()->user();
        $shops = $user->shops;

        $orders = Order::query()
            ->whereIn('shop_id', $shops->pluck('id'))
            ->with(['shop', 'packing'])
            ->where(function ($q) {
                $q->whereDoesntHave('packing')
                    ->orWhereHas('packing', function ($qq) {
                        $qq->where('status', 'pending');
                    });
            })
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('logistics.packings', ['orders' => $orders]);
    }

    public function markPacked(Order $order): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->shops->contains('id', $order->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        DB::transaction(function () use ($order) {
            /** @var OrderPacking $packing */
            $packing = $order->packing ?: $order->packing()->create([
                'shop_id' => $order->shop_id,
                'status' => 'pending',
            ]);

            $packing->update([
                'status' => 'packed',
                'packed_at' => now(),
            ]);
        });

        return back()->with('success', 'Colis marqué comme emballé.');
    }

    public function label(Order $order): View
    {
        $user = auth()->user();
        if (!$user->shops->contains('id', $order->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        $order->load(['shop', 'packing']);
        return view('logistics.label', ['order' => $order]);
    }

    public function returns(): View
    {
        $user = auth()->user();
        $shops = $user->shops;

        $returns = OrderReturn::query()
            ->whereIn('shop_id', $shops->pluck('id'))
            ->with(['order', 'shop'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('logistics.returns', ['returns' => $returns]);
    }

    public function updateReturn(Request $request, OrderReturn $return): RedirectResponse
    {
        $user = auth()->user();
        if (!$user->shops->contains('id', $return->shop_id)) {
            abort(403, 'Accès non autorisé');
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['in_progress', 'accepted', 'refused'])],
            'reason' => ['nullable', 'string'],
        ]);

        $return->update([
            'status' => $validated['status'],
            'reason' => $validated['reason'] ?? $return->reason,
        ]);

        return back()->with('success', 'Retour mis à jour.');
    }
}

