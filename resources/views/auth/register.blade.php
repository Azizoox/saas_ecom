@extends('layouts.layouts')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-12 sm:px-6 lg:px-8 mt-20">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-slate-900 mb-3 tracking-tight">Créer un compte</h1>
            <p class="text-lg text-slate-600 leading-relaxed">Commencez gratuitement. Aucune carte bancaire requise.</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Personal Information Section -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 flex items-center gap-2">
                    <span class="w-1 h-4 bg-gradient-to-b from-blue-500 to-orange-500 rounded"></span>
                    Informations personnelles
                </h2>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-semibold text-slate-700 mb-2">Prénom <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <input id="first_name" type="text" class="w-full pl-12 pr-4 py-3 border-2 border-slate-200 rounded-xl font-medium text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none transition-colors @error('first_name') border-red-500 @enderror" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="Prénom">
                        </div>
                        @error('first_name')
                            <div class="flex items-center gap-1 mt-2 text-sm text-red-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-semibold text-slate-700 mb-2">Nom <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <input id="last_name" type="text" class="w-full pl-12 pr-4 py-3 border-2 border-slate-200 rounded-xl font-medium text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none transition-colors @error('last_name') border-red-500 @enderror" name="last_name" value="{{ old('last_name') }}" required placeholder="Nom">
                        </div>
                        @error('last_name')
                            <div class="flex items-center gap-1 mt-2 text-sm text-red-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Adresse email <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input id="email" type="email" class="w-full pl-12 pr-4 py-3 border-2 border-slate-200 rounded-xl font-medium text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none transition-colors @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required placeholder="exemple@email.com">
                    </div>
                    @error('email')
                        <div class="flex items-center gap-1 mt-2 text-sm text-red-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">Téléphone <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <input id="phone" type="tel" class="w-full pl-12 pr-4 py-3 border-2 border-slate-200 rounded-xl font-medium text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none transition-colors @error('phone') border-red-500 @enderror" name="phone" value="{{ old('phone') }}" required placeholder="+216 XX XXX XXX">
                    </div>
                    @error('phone')
                        <div class="flex items-center gap-1 mt-2 text-sm text-red-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Shop Information Section -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 flex items-center gap-2">
                    <span class="w-1 h-4 bg-gradient-to-b from-blue-500 to-orange-500 rounded"></span>
                    Votre boutique
                </h2>

                <!-- Shop Name -->
                <div class="mb-4">
                    <label for="shop_name" class="block text-sm font-semibold text-slate-700 mb-2">Nom de la boutique <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <input id="shop_name" type="text" class="w-full pl-12 pr-4 py-3 border-2 border-slate-200 rounded-xl font-medium text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none transition-colors @error('shop_name') border-red-500 @enderror" name="shop_name" value="{{ old('shop_name') }}" required placeholder="Ma Super Boutique" oninput="autoFillSubdomain(this.value)">
                    </div>
                    @error('shop_name')
                        <div class="flex items-center gap-1 mt-2 text-sm text-red-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Subdomain -->
                <div>
                    <label for="subdomain" class="block text-sm font-semibold text-slate-700 mb-2">Sous-domaine <span class="text-red-500">*</span></label>
                    <div class="flex border-2 @error('subdomain') border-red-500 @else border-slate-200 @enderror rounded-xl overflow-hidden focus-within:border-blue-500 transition-colors bg-white">
                        <input id="subdomain" type="text" class="flex-1 px-4 py-3 font-medium text-slate-900 placeholder-slate-400 focus:outline-none" name="subdomain" value="{{ old('subdomain') }}" required placeholder="ma-boutique">
                        <div class="flex items-center px-4 py-3 bg-slate-50 border-l border-slate-200 text-slate-600 font-semibold whitespace-nowrap text-sm">.shopino.test</div>
                    </div>
                    <div class="flex items-center gap-2 mt-2 text-xs text-slate-500">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        Votre boutique sera sur : <strong id="subdomain-preview" class="text-slate-700">votre-nom.shopino.test</strong>
                    </div>
                    @error('subdomain')
                        <div class="flex items-center gap-1 mt-2 text-sm text-red-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Security Section -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 flex items-center gap-2">
                    <span class="w-1 h-4 bg-gradient-to-b from-blue-500 to-orange-500 rounded"></span>
                    Sécurité du compte
                </h2>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Mot de passe <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                        <input id="password" type="password" class="w-full pl-12 pr-12 py-3 border-2 border-slate-200 rounded-xl font-medium text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none transition-colors @error('password') border-red-500 @enderror" name="password" required placeholder="Minimum 8 caractères" oninput="checkStrength(this.value)">
                        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 hover:text-blue-500 transition-colors" onclick="togglePassword('password', this)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <div class="mt-2">
                        <div class="h-1 bg-slate-200 rounded-full overflow-hidden">
                            <div class="strength-fill h-full w-0 rounded-full transition-all duration-500" id="strength-fill"></div>
                        </div>
                        <div id="strength-label" class="text-xs font-semibold mt-1 h-4"></div>
                    </div>
                    @error('password')
                        <div class="flex items-center gap-1 mt-2 text-sm text-red-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirmer le mot de passe <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <input id="password_confirmation" type="password" class="w-full pl-12 pr-12 py-3 border-2 border-slate-200 rounded-xl font-medium text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:outline-none transition-colors" name="password_confirmation" required placeholder="Répétez votre mot de passe">
                        <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 hover:text-blue-500 transition-colors" onclick="togglePassword('password_confirmation', this)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-6 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl active:translate-y-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Créer ma boutique gratuitement
            </button>

            <!-- Footer Link -->
            <div class="text-center pt-6 border-t border-slate-200">
                <p class="text-slate-600 text-sm">Vous avez déjà un compte ? <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-orange-500 transition-colors">Connectez-vous →</a></p>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.innerHTML = isHidden
        ? `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
        : `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}

function checkStrength(password) {
    const fill = document.getElementById('strength-fill');
    const label = document.getElementById('strength-label');

    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    const configs = [
        { width: '0%', color: '', text: '' },
        { width: '25%', color: 'bg-red-500', text: 'Très faible' },
        { width: '50%', color: 'bg-orange-500', text: 'Faible' },
        { width: '75%', color: 'bg-yellow-500', text: 'Moyen' },
        { width: '100%', color: 'bg-green-500', text: 'Fort ✓' },
    ];

    const cfg = configs[strength] || configs[0];
    fill.style.width = cfg.width;
    fill.className = `strength-fill h-full rounded-full transition-all duration-500 ${cfg.color}`;
    label.textContent = cfg.text;
    label.className = `text-xs font-semibold mt-1 h-4 ${cfg.color ? cfg.color.replace('bg-', 'text-') : ''}`;
}

function autoFillSubdomain(shopName) {
    const subdomain = shopName
        .toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9\s-]/g, '')
        .trim()
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');

    const subdomainInput = document.getElementById('subdomain');
    const preview = document.getElementById('subdomain-preview');

    if (subdomainInput && !subdomainInput.dataset.manuallyEdited) {
        subdomainInput.value = subdomain;
        preview.textContent = (subdomain || 'votre-nom') + '.shopino.test';
    }
}

document.getElementById('subdomain')?.addEventListener('input', function() {
    this.dataset.manuallyEdited = 'true';
    const preview = document.getElementById('subdomain-preview');
    preview.textContent = (this.value || 'votre-nom') + '.shopino.test';
});
</script>

@endsection