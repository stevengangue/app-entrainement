@extends('layouts.app')

@section('title', 'Tableau de bord Coach')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h2>Bonjour Coach {{ Auth::user()->name }} ! 👋</h2>
                    <p>Bienvenue sur votre tableau de bord. Gérez vos programmes et suivez vos athlètes.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-dumbbell fa-3x mb-3 text-primary"></i>
                    <h3>{{ $stats['total_programs'] }}</h3>
                    <p class="text-muted">Programmes créés</p>
                    <a href="{{ url('/coach/programs') }}" class="btn btn-primary btn-sm">
                        Gérer les programmes
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-users fa-3x mb-3 text-success"></i>
                    <h3>{{ $stats['total_athletes'] }}</h3>
                    <p class="text-muted">Athlètes assignés</p>
                    <a href="{{ url('/coach/athletes') }}" class="btn btn-success btn-sm">
                        Voir mes athlètes
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-plus-circle fa-3x mb-3 text-info"></i>
                    <h3>Nouveau</h3>
                    <p class="text-muted">Créer un programme</p>
                    <a href="{{ url('/coach/programs/create') }}" class="btn btn-info btn-sm text-white">
                        Créer un programme
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>📋 Derniers programmes créés</h5>
                </div>
                <div class="card-body">
                    @forelse($programs->take(5) as $program)
                        <div class="border-bottom mb-2 pb-2">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $program->name }}</strong>
                                <span class="badge bg-primary">{{ $program->difficulty_level }}</span>
                            </div>
                            <p class="small text-muted mb-1">{{ Str::limit($program->description, 80) }}</p>
                            <div class="small">
                                <i class="fas fa-calendar"></i> {{ $program->duration_weeks }} semaines
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">Aucun programme créé</p>
                        <div class="text-center">
                            <a href="{{ url('/coach/programs/create') }}" class="btn btn-primary btn-sm">
                                Créer mon premier programme
                            </a>
                        </div>
                    @endforelse
                    @if($programs->count() > 0)
                        <div class="text-center mt-3">
                            <a href="{{ url('/coach/programs') }}" class="btn btn-sm btn-outline-primary">
                                Voir tous les programmes
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>👥 Mes athlètes</h5>
                </div>
                <div class="card-body">
                    @forelse($athletes->take(5) as $athlete)
                        <div class="border-bottom mb-2 pb-2">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $athlete->name }}</strong>
                                <a href="{{ url('/coach/athletes/' . $athlete->id) }}" class="btn btn-sm btn-outline-primary">
                                    Voir
                                </a>
                            </div>
                            <p class="small text-muted mb-0">{{ $athlete->email }}</p>
                            <p class="small mt-1">
                                <i class="fas fa-dumbbell"></i> {{ $athlete->assignedPrograms->count() }} programme(s)
                            </p>
                        </div>
                    @empty
                        <p class="text-muted text-center">Aucun athlète assigné</p>
                        <small class="text-muted d-block text-center">Les athlètes doivent être assignés par l'administrateur.</small>
                    @endforelse
                    @if($athletes->count() > 0)
                        <div class="text-center mt-3">
                            <a href="{{ url('/coach/athletes') }}" class="btn btn-sm btn-outline-success">
                                Voir tous les athlètes
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
    }
</style>
@endpush
@endsection