@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #1e3a5f;
        --secondary: #3b9dd8;
        --accent: #ff6b35;
        --light: #f8fafc;
        --dark: #0f172a;
    }

    body {
        font-family: 'Outfit', sans-serif;
        background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8f 50%, #3b9dd8 100%);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    .blob {
        position: absolute;
        border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        opacity: 0.1;
        filter: blur(60px);
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px) translateX(0px);
        }
        50% {
            transform: translateY(-30px) translateX(20px);
        }
    }

    .blob-1 {
        width: 400px;
        height: 400px;
        background: #ff6b35;
        top: -100px;
        right: -100px;
    }

    .blob-2 {
        width: 350px;
        height: 350px;
        background: #3b9dd8;
        bottom: -100px;
        left: -100px;
        animation-delay: 2s;
    }

    .login-container {
        position: relative;
        z-index: 10;
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 40px 0;
    }

    .login-wrapper {
        width: 100%;
    }

    .login-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 500px;
        margin: 0 auto;
    }

    .login-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #3b9dd8 100%);
        padding: 48px 40px;
        text-align: center;
        color: white;
    }

    .login-header .logo {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .login-header h1 {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .login-header p {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
    }

    .login-body {
        padding: 40px;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--secondary);
        box-shadow: 0 0 0 4px rgba(59, 157, 216, 0.1);
        outline: none;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-check {
        margin: 20px 0;
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        border: 2px solid #cbd5e1;
        border-radius: 6px;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--secondary);
        border-color: var(--secondary);
    }

    .form-check-label {
        margin-left: 8px;
        color: #475569;
        font-weight: 500;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, #ff6b35 0%, #ff8555 100%);
        border: none;
        border-radius: 12px;
        padding: 16px 32px;
        font-size: 1.1rem;
        font-weight: 700;
        color: white;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-primary:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
    }

    .forgot-password {
        text-align: right;
        margin-top: -8px;
        margin-bottom: 24px;
    }

    .forgot-password a {
        color: var(--secondary);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .forgot-password a:hover {
        color: var(--accent);
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 4px;
    }

    .register-link {
        text-align: center;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }

    .register-link a {
        color: var(--secondary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .register-link a:hover {
        color: var(--accent);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .alert {
        border-radius: 12px;
        border: none;
        padding: 14px 18px;
        margin-bottom: 24px;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }

    @media (max-width: 768px) {
        .login-body {
            padding: 32px 24px;
        }

        .login-header {
            padding: 40px 24px;
        }

        .login-header h1 {
            font-size: 1.8rem;
        }
    }
</style>

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="login-container">
    <div class="login-wrapper">
        <div class="container">
            <div class="login-card">
                <div class="login-header">
                    <div class="logo">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h1>Connexion</h1>
                    <p>Accédez à votre tableau de bord</p>
                </div>

                <div class="login-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email <span class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="exemple@email.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="forgot-password">
                                <a href="{{ route('password.request') }}">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                        @endif

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; margin-right: 8px; vertical-align: middle;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Se connecter
                            </button>
                        </div>

                        @if (Route::has('register'))
                            <div class="register-link">
                                Vous n'avez pas de compte ? <a href="{{ route('register') }}">Créez-en un gratuitement</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection