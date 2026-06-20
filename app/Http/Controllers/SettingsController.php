<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index()
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            return redirect()->route('dashboard')->with('error', 'Aucune boutique trouvée.');
        }
        
        return view('settings.index', compact('shop'));
    }

    public function updateGeneral(Request $request)
    {
        $shop = Auth::user()->shop;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'keywords' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
            'subdomain' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9_-]+$/', Rule::unique('shops')->ignore($shop->id)],
            'custom_domain' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9._-]+$/', Rule::unique('shops')->ignore($shop->id)],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:512',
        ], [
            'subdomain.regex' => 'Le sous-domaine ne peut contenir que des lettres, des chiffres, des tirets et des underscores.',
            'custom_domain.regex' => 'Le domaine personnalisé ne peut contenir que des lettres, des chiffres, des points, des tirets et des underscores.',
        ]);

        if ($request->hasFile('logo')) {
            if ($shop->logo) {
                Storage::disk('public')->delete($shop->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($shop->favicon) {
                Storage::disk('public')->delete($shop->favicon);
            }
            $validated['favicon'] = $request->file('favicon')->store('favicons', 'public');
        }

        $shop->update($validated);

        return back()->with('success', 'Informations générales mises à jour avec succès.');
    }

    public function updateCompany(Request $request)
    {
        $shop = Auth::user()->shop;
        
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:30|regex:/^[+]?[0-9\s-]+$/',
        ], [
            'contact_phone.regex' => 'Le numéro de téléphone doit contenir uniquement des chiffres, des espaces, des tirets ou un signe +.',
        ]);

        $shop->update($validated);

        return back()->with('success', 'Informations de l\'entreprise mises à jour avec succès.');
    }

    public function updateAddress(Request $request)
    {
        $shop = Auth::user()->shop;
        
        $validated = $request->validate([
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $shop->update($validated);

        return back()->with('success', 'Adresse mise à jour avec succès.');
    }

    public function updateDisplay(Request $request)
    {
        $shop = Auth::user()->shop;
        $settings = $shop->settings;
        
        $validated = $request->validate([
            'language' => 'required|string|in:fr,ar,en',
            'currency' => 'required|string|max:10|regex:/^[A-Z]{3}$/',
            'timezone' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'primary_color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'display_mode' => 'required|in:light,dark,auto',
            'date_format' => 'required|string|max:50',
        ], [
            'currency.regex' => 'Le code devise doit être composé de exactement 3 lettres majuscules (ex: TND, USD, EUR).',
            'primary_color.regex' => 'La couleur doit être au format hexadécimal (ex: #3490dc).',
        ]);

        $settings->update($validated);

        return back()->with('success', 'Paramètres d\'affichage mis à jour avec succès.');
    }

    public function updatePayments(Request $request)
    {
        $shop = Auth::user()->shop;
        $settings = $shop->settings;
        
        $validated = $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:50|regex:/^[A-Z0-9\s-]+$/',
            'account_holder' => 'nullable|string|max:255',
            'payment_cod' => 'boolean',
            'payment_bank_transfer' => 'boolean',
            'payment_card' => 'boolean',
        ], [
            'bank_account.regex' => 'Le RIB/IBAN ne peut contenir que des lettres majuscules, des chiffres, des espaces et des tirets.',
        ]);

        // Convert checkbox values to boolean
        $validated['payment_cod'] = $request->has('payment_cod');
        $validated['payment_bank_transfer'] = $request->has('payment_bank_transfer');
        $validated['payment_card'] = $request->has('payment_card');

        $settings->update($validated);

        return back()->with('success', 'Informations bancaires mises à jour avec succès.');
    }

    public function updateSocial(Request $request)
    {
        $shop = Auth::user()->shop;
        $settings = $shop->settings;
        
        $validated = $request->validate([
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'whatsapp_number' => 'nullable|string|max:30|regex:/^[+]?[0-9\s-]+$/',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
        ], [
            'whatsapp_number.regex' => 'Le numéro WhatsApp doit contenir uniquement des chiffres, des espaces, des tirets ou un signe +.',
        ]);

        $settings->update($validated);

        return back()->with('success', 'Réseaux sociaux mis à jour avec succès.');
    }
}
