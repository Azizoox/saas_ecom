@extends('layouts.dashboard')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-600 to-slate-900 p-6 text-white shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="min-w-0">
                <div class="flex items-center gap-3">
                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-white/10 ring-1 ring-inset ring-white/15">
                        <i class="bi bi-gear text-2xl"></i>
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-2xl md:text-3xl font-bold tracking-tight truncate mb-0">Paramètres de la boutique</h1>
                        <p class="mt-1 text-sm text-indigo-100 mb-0">
                            Optimise ta vitrine: identité, domaine, paiements et affichage.
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ url('/') }}" target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-white/20 hover:bg-white/15">
                    <i class="bi bi-box-arrow-up-right"></i>
                    Voir la boutique
                </a>
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm hover:bg-indigo-50">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-2xl bg-emerald-50 px-4 py-3 text-emerald-800 ring-1 ring-inset ring-emerald-200">
            <div class="flex items-start gap-3">
                <i class="bi bi-check-circle-fill mt-0.5"></i>
                <div class="text-sm font-semibold">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded-2xl bg-rose-50 px-4 py-3 text-rose-800 ring-1 ring-inset ring-rose-200">
            <div class="flex items-start gap-3">
                <i class="bi bi-exclamation-triangle-fill mt-0.5"></i>
                <div class="min-w-0">
                    <div class="text-sm font-semibold">Veuillez corriger les champs en erreur.</div>
                    <ul class="mt-2 list-disc pl-5 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Tabs Navigation -->
    <div class="mb-6">
        <div class="flex flex-wrap gap-2">
            <button onclick="showTab(event,'general')" class="tab-btn inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">
                <i class="bi bi-shop"></i>
                Général
            </button>
            <button onclick="showTab(event,'company')" class="tab-btn inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                <i class="bi bi-building"></i>
                Entreprise
            </button>
            <button onclick="showTab(event,'address')" class="tab-btn inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                <i class="bi bi-geo-alt"></i>
                Adresse
            </button>
            <button onclick="showTab(event,'display')" class="tab-btn inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                <i class="bi bi-palette"></i>
                Affichage
            </button>
            <button onclick="showTab(event,'payments')" class="tab-btn inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                <i class="bi bi-credit-card"></i>
                Paiements
            </button>
            <button onclick="showTab(event,'social')" class="tab-btn inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                <i class="bi bi-share"></i>
                Social
            </button>
        </div>
        <p class="mt-3 text-sm text-slate-500">
            Astuce: fais des changements tab par tab, puis clique sur <span class="font-semibold">Enregistrer</span>.
        </p>
    </div>

    <!-- General Info Tab -->
    <div id="general-tab" class="tab-content">
        <form action="{{ route('settings.general') }}" method="POST" enctype="multipart/form-data" class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-6">
            @csrf
            @method('PUT')
            
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 mb-1">Informations générales</h2>
                    <p class="text-sm text-slate-500 mb-0">Nom, SEO, domaine et branding.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Nom de la boutique *
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $shop->name) }}" required
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="keywords">
                    Mots-clés (SEO)
                </label>
                <input type="text" name="keywords" id="keywords" value="{{ old('keywords', $shop->keywords) }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="e-commerce, vente en ligne, produits">
            </div>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea name="description" id="description" rows="3"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $shop->description) }}</textarea>
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="subdomain">
                    Sous-domaine *
                </label>
                <input type="text" name="subdomain" id="subdomain" value="{{ old('subdomain', $shop->subdomain) }}" required
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="monshop">
                <p class="text-slate-500 text-xs mt-1">Ex: monshop.shopino.test</p>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="custom_domain">
                    Domaine personnalisé (optionnel)
                </label>
                <input type="text" name="custom_domain" id="custom_domain" value="{{ old('custom_domain', $shop->custom_domain) }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="www.maboutique.com">
            </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="rounded-2xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="logo">
                    Logo de la boutique
                </label>
                @if($shop->logo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($shop->logo) }}" alt="Logo" class="mb-3 h-20 rounded-xl bg-white ring-1 ring-inset ring-slate-200 p-2">
                @endif
                <input type="file" name="logo" id="logo" accept="image/*"
                    class="block w-full text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-700">
            </div>

            <div class="rounded-2xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="favicon">
                    Favicon
                </label>
                @if($shop->favicon)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($shop->favicon) }}" alt="Favicon" class="mb-3 h-10 w-10 rounded-xl bg-white ring-1 ring-inset ring-slate-200 p-2">
                @endif
                <input type="file" name="favicon" id="favicon" accept="image/*"
                    class="block w-full text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-700">
            </div>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row gap-2 sm:justify-end">
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="bi bi-check2"></i>
                    Enregistrer
                </button>
            </div>
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
        @php
            $currentDisplayMode = old('display_mode', $shop->settings->display_mode ?? 'light');
            $currentPrimaryColor = old('primary_color', $shop->settings->primary_color ?? '#3490dc');
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-8">
                <form action="{{ route('settings.display') }}" method="POST" class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-6">
            @csrf
            @method('PUT')
            
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 mb-1">Affichage</h2>
                    <p class="text-sm text-slate-500 mb-0">Langue, devise, thème, couleur principale et mode clair/sombre.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="language">
                    Langue par défaut *
                </label>
                <select name="language" id="language" required
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="fr" {{ old('language', $shop->settings->language ?? 'fr') == 'fr' ? 'selected' : '' }}>Français</option>
                    <option value="ar" {{ old('language', $shop->settings->language ?? 'fr') == 'ar' ? 'selected' : '' }}>العربية</option>
                    <option value="en" {{ old('language', $shop->settings->language ?? 'fr') == 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="currency">
                    Devise *
                </label>
                <input type="text" name="currency" id="currency" value="{{ old('currency', $shop->settings->currency ?? 'TND') }}" required
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="TND">
            </div>
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="timezone">
                    Fuseau horaire *
                </label>
                <input type="text" name="timezone" id="timezone" value="{{ old('timezone', $shop->settings->timezone ?? 'Africa/Tunis') }}" required
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Africa/Tunis">
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="theme">
                    Thème actif *
                </label>
                <input type="text" name="theme" id="theme" value="{{ old('theme', $shop->settings->theme ?? 'default') }}" required
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="default">
            </div>
            </div>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="rounded-2xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-4">
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-600 mb-2" for="primary_color">
                        Couleur principale
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="primary_color" id="primary_color" value="{{ $currentPrimaryColor }}" required
                               class="h-12 w-16 cursor-pointer rounded-xl border border-slate-300 bg-white shadow-sm">
                        <input type="text" id="primary_color_text" value="{{ $currentPrimaryColor }}" readonly
                               class="flex-1 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm">
                        <button type="button" id="copyPrimaryColor"
                                class="inline-flex items-center gap-2 rounded-xl bg-white px-3 py-2 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 hover:bg-slate-50">
                            <i class="bi bi-clipboard"></i>
                            Copier
                        </button>
                    </div>
                    <p class="mt-2 text-xs text-slate-500 mb-0">Cette couleur personnalise automatiquement les accents du shop.</p>
                </div>

                <div class="rounded-2xl bg-white ring-1 ring-inset ring-slate-200 p-4">
                    <div class="text-xs font-semibold uppercase tracking-wide text-slate-600 mb-2">
                        Mode clair / sombre
                    </div>

                    <div class="grid grid-cols-3 rounded-2xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-1">
                        <label class="group cursor-pointer">
                            <input class="sr-only" type="radio" name="display_mode" value="light" @checked($currentDisplayMode === 'light')>
                            <span class="flex items-center justify-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold ring-1 ring-inset ring-transparent text-slate-700 group-has-[:checked]:bg-white group-has-[:checked]:text-slate-900 group-has-[:checked]:ring-slate-200">
                                <i class="bi bi-sun"></i>
                                Clair
                            </span>
                        </label>
                        <label class="group cursor-pointer">
                            <input class="sr-only" type="radio" name="display_mode" value="dark" @checked($currentDisplayMode === 'dark')>
                            <span class="flex items-center justify-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold ring-1 ring-inset ring-transparent text-slate-700 group-has-[:checked]:bg-white group-has-[:checked]:text-slate-900 group-has-[:checked]:ring-slate-200">
                                <i class="bi bi-moon"></i>
                                Sombre
                            </span>
                        </label>
                        <label class="group cursor-pointer">
                            <input class="sr-only" type="radio" name="display_mode" value="auto" @checked($currentDisplayMode === 'auto')>
                            <span class="flex items-center justify-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold ring-1 ring-inset ring-transparent text-slate-700 group-has-[:checked]:bg-white group-has-[:checked]:text-slate-900 group-has-[:checked]:ring-slate-200">
                                <i class="bi bi-magic"></i>
                                Auto
                            </span>
                        </label>
                    </div>
                    <p class="mt-2 text-xs text-slate-500 mb-0">Auto suit le système (jour/nuit) et laisse l’utilisateur basculer.</p>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date_format">
                    Format de date *
                </label>
                <input type="text" name="date_format" id="date_format" value="{{ old('date_format', $shop->settings->date_format ?? 'd/m/Y') }}" required
                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="d/m/Y">
            </div>

            <div class="mt-6 flex flex-col sm:flex-row gap-2 sm:justify-end">
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="bi bi-check2"></i>
                    Enregistrer
                </button>
            </div>
        </form>
            </div>

            <div class="lg:col-span-4">
                <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-200">
                        <p class="text-sm font-semibold text-slate-900 mb-0"><i class="bi bi-eye me-2 text-slate-500"></i>Aperçu</p>
                    </div>
                    <div class="p-5">
                        <div id="displayPreview" class="rounded-2xl ring-1 ring-inset ring-slate-200 overflow-hidden">
                            <div class="p-4 bg-white text-slate-900">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="h-8 w-8 rounded-xl" id="previewAccentSwatch" style="background: {{ $currentPrimaryColor }};"></div>
                                        <div class="text-sm font-semibold">Boutique</div>
                                    </div>
                                    <span class="text-xs text-slate-500" id="previewModeLabel">{{ strtoupper($currentDisplayMode) }}</span>
                                </div>
                                <div class="mt-4 grid grid-cols-2 gap-2">
                                    <button type="button" class="rounded-xl px-3 py-2 text-sm font-semibold text-white" id="previewPrimaryBtn"
                                            style="background: {{ $currentPrimaryColor }};">
                                        Bouton
                                    </button>
                                    <button type="button" class="rounded-xl px-3 py-2 text-sm font-semibold ring-1 ring-inset ring-slate-200">
                                        Secondaire
                                    </button>
                                </div>
                                <div class="mt-4 rounded-xl bg-slate-50 ring-1 ring-inset ring-slate-200 p-3 text-xs text-slate-600">
                                    Une preview rapide pour valider le rendu du thème.
                                </div>
                            </div>
                        </div>

                        <p class="mt-3 text-xs text-slate-500 mb-0">
                            Le shop applique aussi ces réglages sur `shop/{subdomain}`.
                        </p>
                    </div>
                </div>
            </div>
        </div>
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
function showTab(e, tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active styling from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('bg-indigo-600', 'text-white', 'shadow-sm');
        btn.classList.add('bg-white', 'text-slate-700', 'ring-1', 'ring-inset', 'ring-slate-200');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Add active styling to clicked button
    e.currentTarget.classList.remove('bg-white', 'text-slate-700', 'ring-1', 'ring-inset', 'ring-slate-200');
    e.currentTarget.classList.add('bg-indigo-600', 'text-white', 'shadow-sm');
}

document.addEventListener('DOMContentLoaded', function () {
    const primaryColor = document.getElementById('primary_color');
    const primaryColorText = document.getElementById('primary_color_text');
    const copyPrimaryColor = document.getElementById('copyPrimaryColor');
    const previewSwatch = document.getElementById('previewAccentSwatch');
    const previewPrimaryBtn = document.getElementById('previewPrimaryBtn');
    const previewModeLabel = document.getElementById('previewModeLabel');
    const preview = document.getElementById('displayPreview');

    function getSelectedDisplayMode() {
        const checked = document.querySelector('input[name="display_mode"]:checked');
        return checked ? checked.value : 'light';
    }

    function applyPreview() {
        const color = primaryColor?.value || '#3490dc';
        const mode = getSelectedDisplayMode();

        if (primaryColorText) primaryColorText.value = color;
        if (previewSwatch) previewSwatch.style.background = color;
        if (previewPrimaryBtn) previewPrimaryBtn.style.background = color;
        if (previewModeLabel) previewModeLabel.textContent = mode.toUpperCase();

        if (preview) {
            const inner = preview.querySelector('div');
            if (inner) {
                const dark = mode === 'dark';
                inner.classList.toggle('bg-slate-900', dark);
                inner.classList.toggle('text-slate-100', dark);
                inner.classList.toggle('bg-white', !dark);
                inner.classList.toggle('text-slate-900', !dark);
            }
        }
    }

    primaryColor?.addEventListener('input', applyPreview);
    document.querySelectorAll('input[name="display_mode"]').forEach((el) => el.addEventListener('change', applyPreview));

    copyPrimaryColor?.addEventListener('click', function () {
        const value = primaryColor?.value || primaryColorText?.value;
        if (!value) return;
        navigator.clipboard?.writeText(value);
    });

    applyPreview();
});
</script>
@endsection
