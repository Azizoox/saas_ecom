@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Paramètres de la boutique</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <button onclick="showTab('general')" class="tab-btn border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                Informations générales
            </button>
            <button onclick="showTab('company')" class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Entreprise
            </button>
            <button onclick="showTab('address')" class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Adresse
            </button>
            <button onclick="showTab('display')" class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Affichage
            </button>
            <button onclick="showTab('payments')" class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Paiements
            </button>
            <button onclick="showTab('social')" class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Réseaux sociaux
            </button>
        </nav>
    </div>

    <!-- General Info Tab -->
    <div id="general-tab" class="tab-content">
        <form action="{{ route('settings.general') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            
            <h2 class="text-2xl font-bold mb-6">Informations générales</h2>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Nom de la boutique *
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $shop->name) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="keywords">
                    Mots-clés (SEO)
                </label>
                <input type="text" name="keywords" id="keywords" value="{{ old('keywords', $shop->keywords) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="e-commerce, vente en ligne, produits">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea name="description" id="description" rows="3"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $shop->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="subdomain">
                    Sous-domaine *
                </label>
                <input type="text" name="subdomain" id="subdomain" value="{{ old('subdomain', $shop->subdomain) }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="monshop">
                <p class="text-gray-600 text-xs mt-1">Ex: monshop.shopino.test</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="custom_domain">
                    Domaine personnalisé (optionnel)
                </label>
                <input type="text" name="custom_domain" id="custom_domain" value="{{ old('custom_domain', $shop->custom_domain) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="www.maboutique.com">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="logo">
                    Logo de la boutique
                </label>
                @if($shop->logo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($shop->logo) }}" alt="Logo" class="mb-2 h-20">
                @endif
                <input type="file" name="logo" id="logo" accept="image/*"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="favicon">
                    Favicon
                </label>
                @if($shop->favicon)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($shop->favicon) }}" alt="Favicon" class="mb-2 h-8">
                @endif
                <input type="file" name="favicon" id="favicon" accept="image/*"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Enregistrer
            </button>
        </form>
    </div>

    <!-- Company Tab -->
    <div id="company-tab" class="tab-content hidden">
        <form action="{{ route('settings.company') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            
            <h2 class="text-2xl font-bold mb-6">Informations sur l'entreprise</h2>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="company_name">
                    Nom de l'entreprise
                </label>
                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $shop->company_name) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tax_id">
                    Matricule fiscal
                </label>
                <input type="text" name="tax_id" id="tax_id" value="{{ old('tax_id', $shop->tax_id) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="contact_email">
                    Email de contact
                </label>
                <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $shop->contact_email) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="contact_phone">
                    Téléphone de contact
                </label>
                <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $shop->contact_phone) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Enregistrer
            </button>
        </form>
    </div>

    <!-- Address Tab -->
    <div id="address-tab" class="tab-content hidden">
        <form action="{{ route('settings.address') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            
            <h2 class="text-2xl font-bold mb-6">Adresse de la boutique</h2>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="street">
                    Rue
                </label>
                <input type="text" name="street" id="street" value="{{ old('street', $shop->street) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="city">
                    Ville
                </label>
                <input type="text" name="city" id="city" value="{{ old('city', $shop->city) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="state">
                    Gouvernorat
                </label>
                <input type="text" name="state" id="state" value="{{ old('state', $shop->state) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="postal_code">
                    Code postal
                </label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $shop->postal_code) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="latitude">
                    Latitude (optionnel)
                </label>
                <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $shop->latitude) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="36.8065">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="longitude">
                    Longitude (optionnel)
                </label>
                <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $shop->longitude) }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="10.1815">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Enregistrer
            </button>
        </form>
    </div>

    <!-- Display Tab -->
    <div id="display-tab" class="tab-content hidden">
        <form action="{{ route('settings.display') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            
            <h2 class="text-2xl font-bold mb-6">Affichage (Personnalisation)</h2>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="language">
                    Langue par défaut *
                </label>
                <select name="language" id="language" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="fr" {{ old('language', $shop->settings->language ?? 'fr') == 'fr' ? 'selected' : '' }}>Français</option>
                    <option value="ar" {{ old('language', $shop->settings->language ?? 'fr') == 'ar' ? 'selected' : '' }}>العربية</option>
                    <option value="en" {{ old('language', $shop->settings->language ?? 'fr') == 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="currency">
                    Devise *
                </label>
                <input type="text" name="currency" id="currency" value="{{ old('currency', $shop->settings->currency ?? 'TND') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="TND">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="timezone">
                    Fuseau horaire *
                </label>
                <input type="text" name="timezone" id="timezone" value="{{ old('timezone', $shop->settings->timezone ?? 'Africa/Tunis') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Africa/Tunis">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="theme">
                    Thème actif *
                </label>
                <input type="text" name="theme" id="theme" value="{{ old('theme', $shop->settings->theme ?? 'default') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="primary_color">
                    Couleur principale *
                </label>
                <input type="color" name="primary_color" id="primary_color" value="{{ old('primary_color', $shop->settings->primary_color ?? '#3490dc') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-12">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="display_mode">
                    Mode clair / sombre *
                </label>
                <select name="display_mode" id="display_mode" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="light" {{ old('display_mode', $shop->settings->display_mode ?? 'light') == 'light' ? 'selected' : '' }}>Clair</option>
                    <option value="dark" {{ old('display_mode', $shop->settings->display_mode ?? 'light') == 'dark' ? 'selected' : '' }}>Sombre</option>
                    <option value="auto" {{ old('display_mode', $shop->settings->display_mode ?? 'light') == 'auto' ? 'selected' : '' }}>Automatique</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date_format">
                    Format de date *
                </label>
                <input type="text" name="date_format" id="date_format" value="{{ old('date_format', $shop->settings->date_format ?? 'd/m/Y') }}" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="d/m/Y">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Enregistrer
            </button>
        </form>
    </div>

    <!-- Payments Tab -->
    <div id="payments-tab" class="tab-content hidden">
        <form action="{{ route('settings.payments') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            
            <h2 class="text-2xl font-bold mb-6">Compte bancaire & paiements</h2>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="bank_name">
                    Nom de la banque
                </label>
                <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $shop->settings->bank_name ?? '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="bank_account">
                    RIB / IBAN
                </label>
                <input type="text" name="bank_account" id="bank_account" value="{{ old('bank_account', $shop->settings->bank_account ?? '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="account_holder">
                    Titulaire du compte
                </label>
                <input type="text" name="account_holder" id="account_holder" value="{{ old('account_holder', $shop->settings->account_holder ?? '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Méthodes de paiement activées
                </label>
                
                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="payment_cod" value="1" {{ old('payment_cod', $shop->settings->payment_cod ?? true) ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="ml-2 text-gray-700">Paiement à la livraison</span>
                    </label>
                </div>

                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="payment_bank_transfer" value="1" {{ old('payment_bank_transfer', $shop->settings->payment_bank_transfer ?? false) ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="ml-2 text-gray-700">Virement bancaire</span>
                    </label>
                </div>

                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="payment_card" value="1" {{ old('payment_card', $shop->settings->payment_card ?? false) ? 'checked' : '' }}
                            class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="ml-2 text-gray-700">Carte bancaire</span>
                    </label>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Statut de validation
                </label>
                <p class="text-gray-600">
                    @if(($shop->settings->payment_status ?? 'pending') == 'validated')
                        <span class="text-green-600 font-bold">✓ Validé</span>
                    @elseif(($shop->settings->payment_status ?? 'pending') == 'rejected')
                        <span class="text-red-600 font-bold">✗ Rejeté</span>
                    @else
                        <span class="text-yellow-600 font-bold">⏳ En attente</span>
                    @endif
                </p>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Enregistrer
            </button>
        </form>
    </div>

    <!-- Social Tab -->
    <div id="social-tab" class="tab-content hidden">
        <form action="{{ route('settings.social') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            
            <h2 class="text-2xl font-bold mb-6">Réseaux sociaux</h2>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="facebook_url">
                    Facebook
                </label>
                <input type="url" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', $shop->settings->facebook_url ?? '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="https://facebook.com/votreboutique">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="instagram_url">
                    Instagram
                </label>
                <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $shop->settings->instagram_url ?? '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="https://instagram.com/votreboutique">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tiktok_url">
                    TikTok
                </label>
                <input type="url" name="tiktok_url" id="tiktok_url" value="{{ old('tiktok_url', $shop->settings->tiktok_url ?? '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="https://tiktok.com/@votreboutique">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="whatsapp_number">
                    WhatsApp
                </label>
                <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number', $shop->settings->whatsapp_number ?? '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="+216 12 345 678">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="twitter_url">
                    Twitter / X
                </label>
                <input type="url" name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $shop->settings->twitter_url ?? '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="https://twitter.com/votreboutique">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="youtube_url">
                    YouTube
                </label>
                <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url', $shop->settings->youtube_url ?? '') }}"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="https://youtube.com/@votreboutique">
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Enregistrer
            </button>
        </form>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active styling from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-blue-500', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Add active styling to clicked button
    event.target.classList.remove('border-transparent', 'text-gray-500');
    event.target.classList.add('border-blue-500', 'text-blue-600');
}
</script>
@endsection
