<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Affiche le tableau de bord super admin avec statistiques complètes
     */
    public function index(): View
    {
        $user = auth()->user();

        // Statistiques principales
        $stats = $this->getComprehensiveStats();

        // Derniers utilisateurs
        $recentUsers = User::where('role', '!=', 'super_admin')
            ->latest()
            ->take(5)
            ->get();

        // Dernières boutiques
        $recentShops = Shop::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Dernières commandes
        $recentOrders = Order::with('shop')
            ->latest()
            ->take(10)
            ->get();

        // Statistiques pour graphiques
        $chartData = $this->getChartData();

        return view('super-admin.dashboard', [
            'user' => $user,
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'recentShops' => $recentShops,
            'recentOrders' => $recentOrders,
            'chartData' => $chartData,
            'Order' => Order::class, // Pour la vue
        ]);
    }

    /**
     * Affiche la liste complète des utilisateurs avec gestion
     */
    public function listUsers(Request $request): View
    {
        $query = User::query();

        // Recherche
        if ($request->has('search') && $request->get('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filtre par rôle
        if ($request->has('role') && $request->get('role')) {
            $query->where('role', $request->get('role'));
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $users = $query->paginate(25);

        // Statistiques détaillées par rôle
        $roleStats = [
            'total' => User::count(),
            'super_admin' => User::where('role', 'super_admin')->count(),
            'merchant' => User::where('role', 'merchant')->count(),
            'customer' => User::where('role', 'customer')->count() + User::whereNull('role')->count(),
        ];

        return view('super-admin.users.index', [
            'users' => $users,
            'roleStats' => $roleStats,
            'search' => $request->get('search', ''),
            'role' => $request->get('role', ''),
        ]);
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function showUser(User $user): View
    {
        // Charger les relations
        $user->load('shops');
        
        // Statistiques de l'utilisateur
        $userStats = [
            'shops_count' => $user->shops()->count(),
            'total_products' => Product::whereIn('shop_id', $user->shops()->pluck('id'))->count(),
            'total_orders' => Order::whereIn('shop_id', $user->shops()->pluck('id'))->count(),
            'total_revenue' => Order::whereIn('shop_id', $user->shops()->pluck('id'))
                ->whereNotIn('status', ['cancelled'])
                ->sum('total'),
            'pending_orders' => Order::whereIn('shop_id', $user->shops()->pluck('id'))
                ->whereIn('status', ['new', 'preparing'])
                ->count(),
        ];

        return view('super-admin.users.show', [
            'user' => $user,
            'userStats' => $userStats,
        ]);
    }

    /**
     * Supprime un utilisateur de façon sécurisée
     */
    public function deleteUser(User $user): RedirectResponse
    {
        // Empêcher la suppression du super admin lui-même
        if ($user->id === auth()->id()) {
            return redirect()->route('super-admin.users.index')
                ->with('error', 'Impossible de supprimer votre propre compte.');
        }

        // Empêcher la suppression d'autres super admins (optionnel)
        if ($user->role === 'super_admin') {
            return redirect()->route('super-admin.users.index')
                ->with('error', 'Impossible de supprimer un autre super administrateur.');
        }

        $userName = $user->full_name;
        $userEmail = $user->email;

        try {
            // Soft delete ou hard delete selon le besoin
            $user->delete();

            return redirect()->route('super-admin.users.index')
                ->with('success', "Utilisateur {$userName} ({$userEmail}) a été supprimé avec succès.");
        } catch (\Exception $e) {
            return redirect()->route('super-admin.users.index')
                ->with('error', 'Erreur lors de la suppression de l\'utilisateur: ' . $e->getMessage());
        }
    }

    /**
     * Obtient les statistiques complètes du système
     */
    private function getComprehensiveStats(): array
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::whereNotIn('status', ['cancelled'])->sum('total');

        return [
            // Utilisateurs
            'users_count' => User::count(),
            'users_today' => User::whereDate('created_at', today())->count(),
            'users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            
            // Boutiques
            'shops_count' => Shop::count(),
            'shops_active' => Shop::where('status', 'active')->count(),
            'shops_inactive' => Shop::where('status', '!=', 'active')->count(),
            
            // Produits
            'products_count' => Product::count(),
            'products_active' => Product::where('is_active', true)->count(),
            
            // Catégories
            'categories_count' => Category::count(),
            
            // Commandes
            'orders_count' => $totalOrders,
            'orders_pending' => Order::whereIn('status', ['new', 'preparing'])->count(),
            'orders_completed' => Order::where('status', 'completed')->count(),
            'orders_cancelled' => Order::where('status', 'cancelled')->count(),
            
            // Revenus
            'orders_total_amount' => $totalRevenue,
            'orders_today' => Order::whereDate('created_at', today())->sum('total'),
            'orders_this_month' => Order::whereMonth('created_at', now()->month)->sum('total'),
            'average_order_value' => $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0,
        ];
    }

    /**
     * Affiche la page de modification du profil utilisateur
     */
    public function editProfile(): View
    {
        $user = auth()->user();
         if ($user->role === 'customer') {
            
            return view('shop.profile',['user' => $user ]);
        }
        
        else {
            return view('profile.edit', ['user' => $user]);}
       
           
    }

    /**
     * Met à jour les informations personnelles de l'utilisateur
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'email.unique' => 'Cet email est déjà utilisé.',
        ]);

        // Gérer l'upload de l'avatar
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

            return redirect()->route('profile.edit')
            ->with('success', 'Vos informations ont été mises à jour avec succès.');
           
            
           
    }

    /**
     * Génère les données pour les graphiques
     */
    private function getChartData(): array
    {
        // Commandes par jour (derniers 30 jours)
        $ordersPerDay = [];
        $revenuePerDay = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayLabel = now()->subDays($i)->format('d M');
            
            $ordersPerDay[$dayLabel] = Order::whereDate('created_at', $date)->count();
            $revenuePerDay[$dayLabel] = Order::whereDate('created_at', $date)
                ->whereNotIn('status', ['cancelled'])
                ->sum('total');
        }

        // Utilisateurs par rôle
        $usersByRole = [
            'Super Admin' => User::where('role', 'super_admin')->count(),
            'Marchands' => User::where('role', 'merchant')->count(),
            'Clients' => User::where('role', 'customer')->count() + User::whereNull('role')->count(),
        ];

        // Statut des commandes
        $ordersByStatus = [
            'Nouveau' => Order::where('status', 'new')->count(),
            'En préparation' => Order::where('status', 'preparing')->count(),
            'Complété' => Order::where('status', 'completed')->count(),
            'Annulé' => Order::where('status', 'cancelled')->count(),
        ];

        return [
            'ordersPerDay' => $ordersPerDay,
            'revenuePerDay' => $revenuePerDay,
            'usersByRole' => $usersByRole,
            'ordersByStatus' => $ordersByStatus,
        ];
    }
}
