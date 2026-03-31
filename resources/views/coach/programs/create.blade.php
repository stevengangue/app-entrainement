@extends('layouts.app')

@section('title', 'Créer un programme')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Créer un nouveau programme</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/coach/programs') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nom du programme *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required placeholder="Ex: Programme Prise de Masse">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description *</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="5" required placeholder="Décrivez les objectifs et le contenu du programme...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Durée (semaines) *</label>
                                <input type="number" name="duration_weeks" class="form-control @error('duration_weeks') is-invalid @enderror" 
                                       value="{{ old('duration_weeks', 4) }}" min="1" max="52" required>
                                @error('duration_weeks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Niveau *</label>
                                <select name="difficulty_level" class="form-select @error('difficulty_level') is-invalid @enderror" required>
                                    <option value="">Sélectionnez un niveau</option>
                                    <option value="Débutant" {{ old('difficulty_level') == 'Débutant' ? 'selected' : '' }}>Débutant</option>
                                    <option value="Intermédiaire" {{ old('difficulty_level') == 'Intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                    <option value="Avancé" {{ old('difficulty_level') == 'Avancé' ? 'selected' : '' }}>Avancé</option>
                                    <option value="Expert" {{ old('difficulty_level') == 'Expert' ? 'selected' : '' }}>Expert</option>
                                </select>
                                @error('difficulty_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_public" value="1" class="form-check-input" id="is_public" {{ old('is_public') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_public">
                                Rendre ce programme public (visible par tous les athlètes)
                            </label>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url('/coach/programs') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le programme
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection