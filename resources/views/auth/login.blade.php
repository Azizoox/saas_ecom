@extends('layouts.layouts')

@section('content')

<style>
    :root {
        --primary: #1e3a5f;
        --secondary: #3b9dd8;
        --accent: #ff6b35;
    }

    /* Login Page Container */
    .login-wrapper {
        min-height: calc(100vh - 80px);
     
        position: relative;
        margin-top: 80px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        overflow: hidden;
        grid-template-columns: 1fr 1fr; 



    }

    /* LEFT PANEL - Brand */
    .brand-panel {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8f 50%, #3b9dd8 100%);
        display: center;
        flex-direction: column;
        justify-content: center;
        align-items: center ;
        padding: 80px 60px;
        position: relative;
        overflow: hidden;
    }

    .brand-panel::before {
        content: '';
        position: absolute;
        top: -150px; right: -100px;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: rgba(255, 107, 53, 0.1);
        filter: blur(80px);
    }

    .brand-panel::after {
        content: '';
        position: absolute;
        bottom: -100px; left: -80px;
        width: 400px; height: 400px;
        border-radius: 50%;
        background: rgba(59, 157, 216, 0.12);
        filter: blur(60px);
    }

    .brand-logo {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 56px;
        position: relative;
        z-index: 2;
        animation: fadeInUp 0.6s ease-out;
    }

    .brand-logo-icon {
        width: 48px; height: 48px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .brand-logo-text {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
        letter-spacing: -0.5px;
    }

    .brand-headline {
        position: relative;
        z-index: 2;
        animation: fadeInUp 0.7s ease-out;
        animation-delay: 0.1s;
        opacity: 0;
        animation-fill-mode: forwards;
    }

    .brand-headline h2 {
        font-size: 2.8rem;
        font-weight: 800;
        color: white;
        line-height: 1.15;
        margin-bottom: 24px;
        letter-spacing: -1px;
    }

    .brand-headline h2 span {
        color: #ff6b35;
    }

    .brand-headline p {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.78);
        line-height: 1.7;
        max-width: 420px;
        margin-bottom: 52px;
    }

    .brand-stats {
        display: flex;
        gap: 48px;
        position: relative;
        z-index: 2;
        animation: fadeInUp 0.8s ease-out;
        animation-delay: 0.2s;
        opacity: 0;
        animation-fill-mode: forwards;
    }

    .stat-item {
        text-align: left;
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        color: white;
        line-height: 1;
        margin-bottom: 6px;
    }

    .stat-label {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.65);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        font-weight: 600;
    }

    .brand-features {
        margin-top: 64px;
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 18px;
        animation: fadeInUp 0.9s ease-out;
        animation-delay: 0.3s;
        opacity: 0;
        animation-fill-mode: forwards;
    }

    .brand-feature {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.82);
    }

    .brand-feature-dot {
        width: 8px; height: 8px;
        background: #ff6b35;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* RIGHT PANEL - Form */
    .form-panel {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 80px 60px;
        position: relative;
    }

    .form-panel-inner {
        width: 100%;
        max-width: 420px;
        animation: fadeInRight 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .form-panel-header {
        margin-bottom: 36px;
    }

    .form-panel-header h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .form-panel-header p {
        font-size: 1.05rem;
        color: #64748b;
        line-height: 1.5;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-input-wrapper {
        position: relative;
    }

    .form-input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #cbd5e1;
        pointer-events: none;
        transition: color 0.2s;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px 12px 46px;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.95rem;
        font-family: 'Outfit', sans-serif;
        color: var(--primary);
        background: white;
        transition: all 0.3s ease;
        outline: none;
    }

    .form-control::placeholder {
        color: #cbd5e1;
    }

    .form-control:focus {
        border-color: var(--secondary);
        box-shadow: 0 0 0 4px rgba(59, 157, 216, 0.12);
        background: white;
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    .form-control.no-icon {
        padding-left: 16px;
    }

    .password-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #cbd5e1;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .password-toggle:hover {
        color: var(--secondary);
    }

    .invalid-feedback {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: #ef4444;
        margin-top: 8px;
    }

    .form-extras {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 16px;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        flex: 1;
    }

    .checkbox-wrapper input[type="checkbox"] {
        width: 18px;
        height: 18px;
        border: 1.5px solid #d1d5db;
        border-radius: 5px;
        cursor: pointer;
        accent-color: var(--secondary);
        transition: all 0.2s;
    }

    .checkbox-wrapper input[type="checkbox"]:checked {
        background: var(--secondary);
        border-color: var(--secondary);
    }

    .checkbox-wrapper label {
        font-size: 0.875rem;
        color: #4b5563;
        cursor: pointer;
    }

    .forgot-link {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--secondary);
        text-decoration: none;
        transition: color 0.2s;
        white-space: nowrap;
    }

    .forgot-link:hover {
        color: var(--accent);
    }

    .btn-submit {
        width: 100%;
        padding: 14px 24px;
        background: linear-gradient(135deg, var(--accent) 0%, #ff8555 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 20px;
        letter-spacing: 0.3px;
        box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #e55e2a 0%, #ff7545 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 24px 0;
    }

    .divider-line {
        flex: 1;
        height: 1px;
        background: #e5e7eb;
    }

    .divider-text {
        font-size: 0.8rem;
        color: #9ca3af;
        font-weight: 500;
    }

    .btn-google {
        width: 100%;
        padding: 12px 16px;
        background: white;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 600;
        font-family: 'Outfit', sans-serif;
        color: #374151;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .btn-google:hover {
        border-color: var(--secondary);
        background: #f8fbff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(59, 157, 216, 0.15);
    }

    .form-footer {
        text-align: center;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .form-footer a {
        color: var(--secondary);
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s;
    }

    .form-footer a:hover {
        color: var(--accent);
    }

    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 24px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
        animation: fadeInUp 0.4s ease-out;
    }

    .alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .alert-success {
        background: #f0fdf4;  
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .login-wrapper { grid-template-columns: 1fr; }
        .brand-panel { display: none; }
        .form-panel { padding: 60px 40px; min-height: calc(100vh - 80px); }
        .form-panel-inner { max-width: 100%; }
    }

    @media (max-width: 768px) {
        .brand-panel { padding: 60px 40px; }
        .form-panel { padding: 48px 32px; }
        .brand-headline h2 { font-size: 2.2rem; }
        .form-panel-header h1 { font-size: 1.8rem; }
    }

    @media (max-width: 480px) {
        .login-wrapper { grid-template-columns: 1fr; }
        .brand-panel { display: none; }
        .form-panel { padding: 40px 20px; }
        .brand-logo { margin-bottom: 40px; }
        .brand-headline h2 { font-size: 1.8rem; }
        .form-panel-header h1 { font-size: 1.5rem; }
        .form-panel-header p { font-size: 0.95rem; }
        .btn-submit { padding: 12px 16px; }
        .form-extras { flex-direction: column; align-items: flex-start; gap: 12px; }
        .forgot-link { white-space: normal; }
    }
</style>

<div class="login-wrapper">
  
    <div class="form-panel">
        <div class="form-panel-inner">
            <div class="form-panel-header">
                <h1 class="text-center">Bon retour </h1>

                {{-- <h2>👋</h2> --}}
                <p>Connectez-vous pour accéder à votre boutique</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Adresse email <span class="required">*</span></label>
                    <div class="form-input-wrapper">
                        <svg class="form-input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input
                            id="email"
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                            placeholder="exemple@email.com"
                        >
                    </div>
                    @error('email')
                        <div class="invalid-feedback">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe <span class="required">*</span></label>
                    <div class="form-input-wrapper">
                        <svg class="form-input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                        <input
                            id="password"
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            style="padding-right: 44px;"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)" aria-label="Afficher le mot de passe">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember + Forgot -->
                <div class="form-extras">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" style="margin: 0;">Se souvenir de moi</label>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Se connecter
                </button>


               

               

                @if (Route::has('register'))
                    <div class="form-footer">
                        Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte gratuitement →</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.innerHTML = isHidden
        ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
        : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}
</script>

@endsection