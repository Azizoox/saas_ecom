<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'super_admin') {
                return redirect()->intended(route('super-admin.dashboard'));
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $role = $user ? $user->role : null;
        $subdomain = null;

        // Try to get subdomain from request
        if ($request->has('subdomain')) {
            $subdomain = $request->input('subdomain');
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'customer' && $subdomain) {
            return redirect()->intended(route('shop.index', ['subdomain' => $subdomain]));
        }

        return redirect()->route('login');
    }
    public function showCostumeLogin(): View
    {
        $shop = app('shop');
        
        if (!$shop) {
            abort(404);
        }
        
        return view('shop.auth.login', ['shop' => $shop]);
    }

    public function storeCustomer(Request $request): RedirectResponse
    {
        $shop = app('shop');
        
        if (!$shop) {
            abort(404);
        }
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('shop.index', ['subdomain' => $shop->subdomain]));
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }
}
