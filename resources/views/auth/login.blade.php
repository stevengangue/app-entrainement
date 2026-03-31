@extends('layouts.app')

@section('title', 'Connexion - FitTrack Pro')

@section('content')
<div class="row justify-content-center" data-aos="fade-up">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg">
            <div class="card-header text-center">
                <i class="fas fa-sign-in-alt fa-2x mb-2"></i>
                <h3 class="mb-0">Bienvenue</h3>
                <p class="mb-0 text-white-50">Connectez-vous à votre compte</p>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">
                            <i class="fas fa-envelope me-2 text-primary"></i>Adresse email
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="exemple@email.com" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold">
                            <i class="fas fa-lock me-2 text-primary"></i>Mot de passe
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" 
                               placeholder="••••••••" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Se souvenir de moi
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="fas fa-arrow-right-to-bracket me-2"></i>Se connecter
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-muted mb-0">
                        Pas encore de compte ? 
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">
                            Inscrivez-vous gratuitement
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <small class="text-white-50">
                <i class="fas fa-shield-alt me-1"></i> Vos données sont sécurisées
            </small>
        </div>
    </div>
</div>
@endsection