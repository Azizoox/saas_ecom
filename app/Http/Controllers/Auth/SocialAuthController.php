<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    // Redirige vers Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Gère le retour de Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['msg' => 'Connexion Google échouée.']);
        }

        // Cherche ou crée l'utilisateur
        $nameParts = explode(' ', $googleUser->name, 2);
        $user = User::updateOrCreate(
            ['google_id' => $googleUser->id],
            [
                'first_name' => $nameParts[0],
                'last_name'  => $nameParts[1] ?? '',
                'email'      => $googleUser->email,
                'avatar'     => $googleUser->avatar,
            ]
        );

        Auth::login($user, true); // true = remember me

        return redirect()->intended('/dashboard');
    }
}