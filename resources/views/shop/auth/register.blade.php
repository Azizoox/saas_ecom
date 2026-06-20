@extends('shop.layouts.app')

@section('title', 'Register - ' . $shop->name)

@push('styles')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
<style>
    body { font-family: 'DM Sans', sans-serif; }
    .brand-panel {
        background: var(--c-accent);
        background-image:
            radial-gradient(ellipse at 20% 20%, var(--c-accent) 0%, transparent 60%),
            radial-gradient(ellipse at 80% 80%, var(--c-accent-dk) 0%, transparent 60%);
    }
    .circle-deco-1 {
        position: absolute; top: -80px; right: -80px;
        width: 260px; height: 260px; border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.06);
    }
    .circle-deco-2 {
        position: absolute; bottom: 60px; left: -60px;
        width: 180px; height: 180px; border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .input-field {
        width: 100%;
        padding: 10px 14px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fafafa;
        color: #111;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .input-field:focus {
        border-color: var(--c-accent-dk);
        background: #fff;
        box-shadow: 0 0 0 3px var(--c-accent-dk);
    }
    .input-field.is-invalid { border-color: #ef4444; }
    .input-field.is-invalid:focus { box-shadow: 0 0 0 3px var(--c-accent-dk); }
    .btn-submit {
        width: 100%; padding: 12px;
        background: var(--c-accent);
        color: white; font-weight: 600; font-size: 15px;
        border: none; border-radius: 10px; cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        font-family: 'DM Sans', sans-serif;
        letter-spacing: 0.01em;
    }
    .btn-submit:hover { background: var(--c-accent-dk); }
    .btn-submit:active { transform: scale(0.98); }
    .strength-bar { height: 3px; background: #e5e7eb; border-radius: 2px; margin-top: 6px; overflow: hidden; }
    .strength-fill { height: 100%; width: 0; border-radius: 2px; transition: width 0.3s, background 0.3s; }
    .password-wrapper { position: relative; }
    .pw-toggle {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #9ca3af; font-size: 12px; font-family: 'DM Sans', sans-serif;
        padding: 2px 4px;
    }
    .pw-toggle:hover { color: var(--c-accent-dk); }
    .feature-item { display: flex; align-items: center; gap: 10px; }
    .feature-check {
        width: 20px; height: 20px; border-radius: 50%;
        background: rgba(255,255,255,0.12);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .color {
        color: var(--c-accent);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-10 px-4">
    <div class="w-full max-w-4xl rounded-2xl overflow-hidden shadow-xl flex" style="min-height: 580px;">

        {{-- Brand Panel --}}
        <div class="brand-panel relative hidden md:flex flex-col justify-between p-10 w-5/12 flex-shrink-0 overflow-hidden">
            <div class="circle-deco-1"></div>
            <div class="circle-deco-2"></div>

            {{-- Logo --}}
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <span class="text-white font-semibold text-sm tracking-wide">{{ $shop->name }}</span>
                </div>
            </div>

            {{-- Content --}}
            <div class="relative z-10 flex-1 flex flex-col justify-center py-8">
                <p class="text-white/50 text-xs uppercase tracking-widest font-medium mb-3">Why join us?</p>
                <h2 style="font-family:'DM Serif Display',serif;" class="text-white text-3xl leading-tight mb-6">
                    Your favourite<br>store, reimagined.
                </h2>
                <div class="space-y-3">
                    @foreach([
                        'Free shipping on orders over $50',
                        '30-day hassle-free returns',
                        'Exclusive member discounts',
                        '24/7 customer support'
                    ] as $feature)
                    <div class="feature-item">
                        <div class="feature-check">
                            <svg class="w-3 h-3 text-indigo-300 " fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-white/70 text-sm">{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Bottom social proof --}}
            <div class="relative z-10">
                <div class="flex -space-x-2 mb-2">
                    @foreach(['J','M','A','S'] as $initial)
                    <div class="w-7 h-7 rounded-full bg-white/20 border-2 border-white/30 flex items-center justify-center text-white text-xs font-medium">{{ $initial }}</div>
                    @endforeach
                </div>
                <p class="text-white/50 text-xs">Join <span class="text-white font-medium">8,000+</span> happy customers</p>
            </div>
        </div>

        {{-- Form Panel --}}
        <div class="flex-1 bg-white p-8 md:p-10 flex flex-col justify-center">
            <div class="mb-7">
                <h1 class="text-2xl font-semibold text-gray-900 mb-1">Create account</h1>
                <p class="text-sm text-gray-500">Fill in your details to get started</p>
            </div>

            <form method="POST" action="{{ route('shop.register.store', ['subdomain' => $shop->subdomain]) }}" novalidate>
                @csrf

                {{-- First + Last name --}}
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label for="first_name" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1.5">First name</label>
                        <input
                            id="first_name" name="first_name" type="text"
                            value="{{ old('first_name') }}"
                            placeholder="John"
                            required autocomplete="given-name" autofocus
                            class="input-field @error('first_name') is-invalid @enderror"
                        >
                        @error('first_name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1.5">Last name</label>
                        <input
                            id="last_name" name="last_name" type="text"
                            value="{{ old('last_name') }}"
                            placeholder="Doe"
                            required autocomplete="family-name"
                            class="input-field @error('last_name') is-invalid @enderror"
                        >
                        @error('last_name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Phone --}}
                <div class="mb-4">
                    <label for="phone" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1.5">Phone</label>
                    <input
                        id="phone" name="phone" type="tel"
                        value="{{ old('phone') }}"
                        placeholder="+1 (555) 000-0000"
                        required autocomplete="tel"
                        class="input-field @error('phone') is-invalid @enderror"
                    >
                    @error('phone')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1.5">Email address</label>
                    <input
                        id="email" name="email" type="email"
                        value="{{ old('email') }}"
                        placeholder="john@example.com"
                        required autocomplete="email"
                        class="input-field @error('email') is-invalid @enderror"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1.5">Password</label>
                    <div class="password-wrapper">
                        <input
                            id="password" name="password" type="password"
                            placeholder="Min. 8 characters"
                            required autocomplete="new-password"
                            oninput="updateStrength(this.value)"
                            class="input-field @error('password') is-invalid @enderror"
                        >
                        <button type="button" class="pw-toggle" onclick="togglePw('password', this)">show</button>
                    </div>
                    <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-5">
                    <label for="password_confirmation" class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1.5">Confirm password</label>
                    <div class="password-wrapper">
                        <input
                            id="password_confirmation" name="password_confirmation" type="password"
                            placeholder="Repeat your password"
                            required autocomplete="new-password"
                            class="input-field"
                        >
                        <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)">show</button>
                    </div>
                </div>

                {{-- Terms --}}
                <div class="flex items-start gap-2.5 mb-5">
                    <input type="checkbox" id="terms" name="terms" required
                        class="mt-0.5 w-4 h-4 rounded border-gray-300 accent-indigo-600 flex-shrink-0">
                    <label for="terms" class="text-xs text-gray-500 leading-relaxed">
                        I agree to the
                        <a href="#" class="color font-medium hover:underline">Terms of Service</a>
                        and
                        <a href="#" class="color font-medium hover:underline">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit" class="btn-submit">Create account</button>

                <p class="mt-4 text-center text-sm text-gray-500">
                    Already have an account?
                    <a href="{{ route('shop.login', ['subdomain' => $shop->subdomain]) }}" class="color font-medium hover:underline">Sign in</a>
                </p>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePw(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') { input.type = 'text'; btn.textContent = 'hide'; }
    else { input.type = 'password'; btn.textContent = 'show'; }
}
function updateStrength(val) {
    const fill = document.getElementById('strength-fill');
    let score = 0;
    if (val.length >= 8) score += 25;
    if (/[A-Z]/.test(val)) score += 25;
    if (/[0-9]/.test(val)) score += 25;
    if (/[^A-Za-z0-9]/.test(val)) score += 25;
    fill.style.width = score + '%';
    fill.style.background = score <= 25 ? '#ef4444' : score <= 50 ? '#f97316' : score <= 75 ? '#eab308' : '#22c55e';
}
</script>
@endpush
@endsection