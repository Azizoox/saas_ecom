<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ShopAuthController extends Controller
{
    public function getShop($subdomain)
    {
        return Shop::where('subdomain', $subdomain)->firstOrFail();
    }

    // Login
    public function showLogin($subdomain)
    {
        $shop = $this->getShop($subdomain);
        return view('shop.auth.login', compact('shop'));
    }

    public function storeLogin(Request $request, $subdomain)
    {
        $shop = $this->getShop($subdomain);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('shop.index', $subdomain)->with('success', 'Connecté avec succès!');
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ])->onlyInput('email');
    }

    // Register
    public function showRegister($subdomain)
    {
        $shop = $this->getShop($subdomain);
        return view('shop.auth.register', compact('shop'));
    }

    public function storeRegister(Request $request, $subdomain)
    {
        $shop = $this->getShop($subdomain);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:8'],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('shop.index', $subdomain)->with('success', 'Compte créé avec succès!');
    }

    // Logout
    public function logout(Request $request, $subdomain)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('shop.index', $subdomain)->with('success', 'Vous êtes déconnecté.');
    }
}
