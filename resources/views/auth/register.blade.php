@extends('layouts.app')

@section('title', 'Inscription - FitTrack Pro')

@section('content')
<div class="row justify-content-center" data-aos="fade-up">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg">
            <div class="card-header text-center">
                <i class="fas fa-user-plus fa-2x mb-2"></i>
                <h3 class="mb-0">Créez votre compte</h3>
                <p class="mb-0 text-white-50">Rejoignez la communauté FitTrack Pro</p>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">
                            <i class="fas fa-user me-2 text-success"></i>Nom complet
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="*********" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">
                            <i class="fas fa-envelope me-2 text-success"></i>Adresse email
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="exemple@email.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-bold">
                            <i class="fas fa-id-card me-2 text-success"></i>Je suis
                        </label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">Sélectionnez votre profil</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                🏋️‍♂️ Athlète - Je veux suivre mes entraînements
                            </option>
                            <option value="coach" {{ old('role') == 'coach' ? 'selected' : '' }}>
                                👨‍🏫 Coach - Je veux créer des programmes
                            </option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">
                            <i class="fas fa-lock me-2 text-success"></i>Mot de passe
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" 
                               placeholder="••••••••" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimum 8 caractères</small>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-bold">
                            <i class="fas fa-check-circle me-2 text-success"></i>Confirmer le mot de passe
                        </label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" 
                               placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2">
                        <i class="fas fa-user-plus me-2"></i>S'inscrire gratuitement
                    </button>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-muted mb-0">
                        Déjà un compte ? 
                        <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">
                            Connectez-vous
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <small class="text-white-50">
                <i class="fas fa-check-circle me-1"></i> Inscription gratuite
                <i class="fas fa-shield-alt ms-3 me-1"></i> Sécurisé
            </small>
        </div>
    </div>
</div>
@endsection