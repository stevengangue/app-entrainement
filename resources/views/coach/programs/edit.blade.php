@extends('layouts.app')

@section('title', 'Modifier le programme')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Modifier le programme</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/coach/programs/' . $program->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>Nom du programme</label>
                            <input type="text" name="name" class="form-control" value="{{ $program->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="5" required>{{ $program->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Durée (semaines)</label>
                                <input type="number" name="duration_weeks" class="form-control" value="{{ $program->duration_weeks }}" min="1" max="52" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Niveau</label>
                                <select name="difficulty_level" class="form-control" required>
                                    <option value="Débutant" {{ $program->difficulty_level == 'Débutant' ? 'selected' : '' }}>Débutant</option>
                                    <option value="Intermédiaire" {{ $program->difficulty_level == 'Intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                    <option value="Avancé" {{ $program->difficulty_level == 'Avancé' ? 'selected' : '' }}>Avancé</option>
                                    <option value="Expert" {{ $program->difficulty_level == 'Expert' ? 'selected' : '' }}>Expert</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_public" value="1" class="form-check-input" {{ $program->is_public ? 'checked' : '' }}>
                            <label class="form-check-label">Rendre public</label>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ url('/coach/programs') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection