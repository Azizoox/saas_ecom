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
            'keywords' => 'nullable|string',
            'description' => 'nullable|string|max:1000',
            'subdomain' => ['required', 'string', 'max:255', Rule::unique('shops')->ignore($shop->id)],
            'custom_domain' => ['nullable', 'string', 'max:255', Rule::unique('shops')->ignore($shop->id)],
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:512',
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
            'tax_id' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
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
            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'primary_color' => 'required|string|max:7',
            'display_mode' => 'required|in:light,dark,auto',
            'date_format' => 'required|string|max:50',
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
            'bank_account' => 'nullable|string|max:255',
            'account_holder' => 'nullable|string|max:255',
            'payment_cod' => 'boolean',
            'payment_bank_transfer' => 'boolean',
            'payment_card' => 'boolean',
        ]);

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
            'whatsapp_number' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
        ]);

        $settings->update($validated);

        return back()->with('success', 'Réseaux sociaux mis à jour avec succès.');
    }
}
