@extends('layouts.app')

@section('title', 'Nouvelle performance')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus me-2"></i>Enregistrer une performance</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('performances.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Exercice *</label>
                            <select name="exercise_id" class="form-select @error('exercise_id') is-invalid @enderror" required>
                                <option value="">Sélectionner un exercice</option>
                                @foreach($exercises as $exercise)
                                    <option value="{{ $exercise->id }}" {{ old('exercise_id') == $exercise->id ? 'selected' : '' }}>
                                        {{ $exercise->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('exercise_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Séance (optionnel)</label>
                            <select name="workout_id" class="form-select">
                                <option value="">Séance libre</option>
                                @foreach($workouts as $workout)
                                    <option value="{{ $workout->id }}" {{ old('workout_id') == $workout->id ? 'selected' : '' }}>
                                        {{ $workout->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Séries *</label>
                                <input type="number" name="sets_completed" class="form-control @error('sets_completed') is-invalid @enderror" 
                                       value="{{ old('sets_completed', 3) }}" min="1" required>
                                @error('sets_completed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Répétitions *</label>
                                <input type="number" name="reps_completed" class="form-control @error('reps_completed') is-invalid @enderror" 
                                       value="{{ old('reps_completed', 10) }}" min="1" required>
                                @error('reps_completed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Poids (kg)</label>
                                <input type="number" name="weight_used" class="form-control @error('weight_used') is-invalid @enderror" 
                                       value="{{ old('weight_used') }}" step="0.5" min="0">
                                @error('weight_used')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Durée (secondes)</label>
                                <input type="number" name="duration_seconds" class="form-control @error('duration_seconds') is-invalid @enderror" 
                                       value="{{ old('duration_seconds') }}" min="0">
                                @error('duration_seconds')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Date *</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                                   value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('performances.index') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection