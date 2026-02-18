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

    .register-container {
        position: relative;
        z-index: 10;
        padding: 40px 0;
    }

    .register-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
    }

    .register-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #3b9dd8 100%);
        padding: 40px;
        text-align: center;
        color: white;
    }

    .register-header .logo {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }

    .register-header h1 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .register-header p {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
    }

    .register-body {
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
        padding: 12px 16px;
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

    .input-group-text {
        background: #f1f5f9;
        border: 2px solid #e2e8f0;
        border-left: none;
        border-radius: 0 12px 12px 0;
        color: #64748b;
        font-weight: 500;
    }

    .input-group .form-control {
        border-right: none;
        border-radius: 12px 0 0 12px;
    }

    .input-group .form-control:focus + .input-group-text {
        border-color: var(--secondary);
    }

    .btn-primary {
        background: linear-gradient(135deg, #ff6b35 0%, #ff8555 100%);
        border: none;
        border-radius: 12px;
        padding: 14px 32px;
        font-size: 1.1rem;
        font-weight: 700;
        color: white;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
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

    .text-danger {
        color: #dc3545 !important;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 4px;
    }

    .form-text {
        color: #64748b;
        font-size: 0.875rem;
    }

    .login-link {
        text-align: center;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }

    .login-link a {
        color: var(--secondary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .login-link a:hover {
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

    .register-card {
        animation: fadeInUp 0.6s ease-out;
    }

    @media (max-width: 768px) {
        .register-body {
            padding: 24px;
        }

        .register-header {
            padding: 32px 24px;
        }

        .register-header h1 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="register-container">
    <div class="container">
        <div class="register-card">
            <div class="register-header">
                <div class="logo">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h1>Créer votre boutique Shopino</h1>
                <p>Lancez votre business en ligne en quelques minutes</p>
            </div>

            <div class="register-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="Votre prénom">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required placeholder="Votre nom">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="exemple@email.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Numéro de téléphone <span class="text-danger">*</span></label>
                        <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required placeholder="+216 XX XXX XXX">
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="shop_name" class="form-label">Nom de la boutique <span class="text-danger">*</span></label>
                        <input id="shop_name" type="text" class="form-control @error('shop_name') is-invalid @enderror" name="shop_name" value="{{ old('shop_name') }}" required placeholder="Ma Super Boutique">
                        @error('shop_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subdomain" class="form-label">Sous-domaine de la boutique <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input id="subdomain" type="text" class="form-control @error('subdomain') is-invalid @enderror" name="subdomain" value="{{ old('subdomain') }}" required placeholder="ma-boutique">
                            <span class="input-group-text">.shopino.test</span>
                        </div>
                        <small class="form-text">Votre boutique sera accessible sur : <strong>votre-nom.shopino.test</strong></small>
                        @error('subdomain')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="••••••••">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirmation <span class="text-danger">*</span></label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; margin-right: 8px; vertical-align: middle;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Créer ma boutique gratuitement
                        </button>
                    </div>

                    <div class="login-link">
                        Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous ici</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection