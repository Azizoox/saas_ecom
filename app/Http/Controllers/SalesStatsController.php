<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalesStatsController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        $shops = $user->shops;

        $period = $request->string('period', 'month')->toString(); // day|month
        $period = in_array($period, ['day', 'month'], true) ? $period : 'month';

        $base = Order::query()
            ->whereIn('shop_id', $shops->pluck('id'))
            ->whereNotIn('status', [Order::STATUS_CANCELLED]);

        $totalSales = (float) $base->sum('total');
        $ordersCount = (int) $base->count();
        $avgBasket = $ordersCount > 0 ? $totalSales / $ordersCount : 0;

        $groupExpr = $period === 'day'
            ? "DATE(created_at)"
            : "DATE_FORMAT(created_at, '%Y-%m-01')";

        $salesByPeriod = Order::query()
            ->selectRaw("$groupExpr as bucket, SUM(total) as total_sales, COUNT(*) as orders_count")
            ->whereIn('shop_id', $shops->pluck('id'))
            ->whereNotIn('status', [Order::STATUS_CANCELLED])
            ->groupBy('bucket')
            ->orderBy('bucket')
            ->get();

        return view('stats.sales', [
            'totalSales' => $totalSales,
            'ordersCount' => $ordersCount,
            'avgBasket' => $avgBasket,
            'period' => $period,
            'salesByPeriod' => $salesByPeriod,
        ]);
    }
}

