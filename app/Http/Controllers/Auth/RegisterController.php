<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Shop;
use App\Models\ShopSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'shop_name' => ['required', 'string', 'max:255'],
            'subdomain' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:shops,subdomain'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
           
        
        


        // Créer l'utilisateur
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'owner',
        ]);

        // Créer la boutique
        $shop = Shop::create([
            'user_id' => $user->id,
            'name' => $request->shop_name,
            'subdomain' => $request->subdomain,
            'status' => 'active',
        ]);

        // Créer les paramètres par défaut
        ShopSetting::create([
            'shop_id' => $shop->id,
            'currency' => 'TND',
            'language' => 'FR',
            'theme' => 'default',
            'logo' => null,
            'settings' => [],
        ]);

        // Créer les pages par défaut
        $defaultPages = [
            ['title' => 'Accueil', 'slug' => 'accueil', 'order' => 1],
            ['title' => 'Boutique', 'slug' => 'boutique', 'order' => 2],
            ['title' => 'À propos', 'slug' => 'a-propos', 'order' => 3],
            ['title' => 'Contact', 'slug' => 'contact', 'order' => 4],
            ['title' => 'Politique de confidentialité', 'slug' => 'politique-de-confidentialite', 'order' => 5],
        ];

        foreach ($defaultPages as $pageData) {
            Page::create([
                'shop_id' => $shop->id,
                'title' => $pageData['title'],
                'slug' => $pageData['slug'],
                'content' => '<p>Contenu de la page ' . $pageData['title'] . '</p>',
                'is_active' => true,
                'order' => $pageData['order'],
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        // Cette appli n'enregistre pas forcément le listener framework dans `EventServiceProvider`,
        // donc on envoie l'email explicitement si nécessaire.
        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return redirect()->route('verification.notice');
    }
    public function showCostumeRegister(): View
    {
        $shop = app('shop');
        
        if (!$shop) {
            abort(404);
        }
        
        return view('shop.auth.register', ['shop' => $shop]);
    }

    public function storeCustomer(Request $request): RedirectResponse
    {
        $shop = app('shop');
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
           
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Send email verification if needed
        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return redirect()->route('shop.index', ['subdomain' => $shop->subdomain]);
    }
    


}