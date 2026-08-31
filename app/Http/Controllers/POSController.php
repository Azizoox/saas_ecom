<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use App\Models\CashRegisterSession;
use App\Models\PosOrder;
use App\Models\PosOrderItem;
use App\Models\Product;
use App\Models\ShopSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class POSController extends Controller
{
    public function index()
    {
        $cashRegisters = CashRegister::where('is_active', true)->get();
        $currentSession = CashRegisterSession::where('user_id', Auth::id())
            ->where('status', 'open')
            ->with(['cashRegister', 'user'])
            ->first();
        
        $currentRegister = $currentSession ? $currentSession->cashRegister : null;
        
        return view('pos.index', compact('cashRegisters', 'currentSession', 'currentRegister'));
    }
    
    public function createRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);
        
        CashRegister::create([
            'name' => $request->name,
            'location' => $request->location,
            'is_active' => true,
            'opening_balance' => 0,
        ]);
        
        return redirect()->back()->with('success', 'Caisse créée avec succès!');
    }
    
    public function openRegister(Request $request)
    {
        $request->validate([
            'cash_register_id' => 'required|exists:cash_registers,id',
            'opening_balance' => 'required|numeric|min:0',
        ]);
        
        $cashRegister = CashRegister::findOrFail($request->cash_register_id);
        
        // Check if user already has an open session
        $existingSession = CashRegisterSession::where('user_id', Auth::id())
            ->where('status', 'open')
            ->first();
            
        if ($existingSession) {
            return redirect()->back()->with('error', 'Vous avez déjà une caisse ouverte!');
        }
        
        CashRegisterSession::create([
            'cash_register_id' => $request->cash_register_id,
            'user_id' => Auth::id(),
            'opened_at' => now(),
            'opening_balance' => $request->opening_balance,
            'status' => 'open',
        ]);
        
        return redirect()->back()->with('success', 'Caisse ouverte avec succès!');
    }
    
    public function closeRegister(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:cash_register_sessions,id',
            'actual_closing_balance' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        
        $session = CashRegisterSession::findOrFail($request->session_id);
        
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }
        
        $expectedBalance = $session->opening_balance;
        
        // Calculate expected balance based on sales
        $salesAmount = $session->posOrders()->completed()->sum('total_amount');
        $expectedBalance += $salesAmount;
        
        $actualBalance = $request->actual_closing_balance;
        $difference = $actualBalance - $expectedBalance;
        
        $session->update([
            'closed_at' => now(),
            'expected_closing_balance' => $expectedBalance,
            'actual_closing_balance' => $actualBalance,
            'difference' => $difference,
            'status' => 'closed',
            'notes' => $request->notes,
        ]);
        
        return redirect()->back()->with('success', 'Caisse fermée avec succès!');
    }
    
    public function orders()
    {
        $orders = PosOrder::whereHas('cashRegisterSession', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->orWhere('user_id', Auth::id())
        ->with(['user', 'customer', 'cashRegisterSession.cashRegister', 'orderItems'])
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        
        return view('pos.orders', compact('orders'));
    }
    
    public function history()
    {
        $sessions = CashRegisterSession::whereHas('cashRegister', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->orWhere('user_id', Auth::id())
        ->with(['cashRegister', 'user', 'posOrders'])
        ->orderBy('opened_at', 'desc')
        ->paginate(15);
        
        // Calculate totals
        $totalCashSales = 0;
        $totalCardSales = 0;
        $totalSales = 0;
        
        foreach ($sessions as $session) {
            $sessionOrders = $session->posOrders;
            foreach ($sessionOrders as $order) {
                if ($order->payment_method === 'cash') {
                    $totalCashSales += $order->total_amount;
                } elseif ($order->payment_method === 'card') {
                    $totalCardSales += $order->total_amount;
                }
                $totalSales += $order->total_amount;
            }
        }
        
        return view('pos.history', compact('sessions', 'totalCashSales', 'totalCardSales', 'totalSales'));
    }
    
    public function createOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        
        $currentSession = CashRegisterSession::where('user_id', Auth::id())
            ->where('status', 'open')
            ->first();
            
        if (!$currentSession) {
            return response()->json(['error' => 'Aucune caisse ouverte'], 400);
        }
        
        DB::beginTransaction();
        
        try {
            // Generate order number
            $orderNumber = date('Ymd') . str_pad(PosOrder::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
            
            $subtotal = 0;
            $taxAmount = 0;
            
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $itemTotal = $product->price * $item['quantity'];
                $itemTax = $itemTotal * ($product->tax_rate / 100);
                
                $subtotal += $itemTotal;
                $taxAmount += $itemTax;
            }
            
            $totalAmount = $subtotal + $taxAmount;
            
            $order = PosOrder::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'cash_register_session_id' => $currentSession->id,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => $totalAmount, // Assume full payment
                'change_amount' => 0,
                'payment_method' => 'cash',
                'status' => 'completed',
            ]);
            
            // Create order items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                $unitPrice = $product->price;
                $lineTotal = $unitPrice * $item['quantity'];
                $taxRate = $product->tax_rate ?? 0;
                $taxAmount = $lineTotal * ($taxRate / 100);
                
                PosOrderItem::create([
                    'pos_order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'line_total' => $lineTotal,
                    'tax_rate' => $taxRate,
                    'tax_amount' => $taxAmount,
                ]);
            }
            
            DB::commit();
            
            return response()->json(['success' => true, 'order_id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function searchProducts(Request $request)
    {
        $query = $request->input('q');
        
        $products = \App\Models\Product::where(function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('sku', 'LIKE', "%{$query}%");
        })
        ->where('is_active', true)
        ->limit(10)
        ->get(['id', 'name', 'price', 'stock_quantity']);
        
        return response()->json($products);
    }
}
