@extends('layouts.app')

@section('title', $program->name)

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>{{ $program->name }}</h2>
                            <p class="mb-0">Coach: {{ $program->user->name }}</p>
                        </div>
                        <i class="fas fa-dumbbell fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Description du programme</h5>
                </div>
                <div class="card-body">
                    <p>{{ $program->description }}</p>
                    <div class="mt-3">
                        <span class="badge bg-primary">{{ $program->difficulty_level }}</span>
                        <span class="badge bg-info">{{ $program->duration_weeks }} semaines</span>
                        @if($program->is_public)
                            <span class="badge bg-success">Public</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Séances d'entraînement</h5>
                </div>
                <div class="card-body">
                    @if($program->workouts->count() > 0)
                        @foreach($program->workouts->groupBy('week_number') as $week => $workouts)
                            <div class="mb-4">
                                <h6 class="text-primary">Semaine {{ $week }}</h6>
                                @foreach($workouts as $workout)
                                    <div class="border rounded p-3 mb-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Jour {{ $workout->day_number }} - {{ $workout->name }}</strong>
                                                @if($workout->description)
                                                    <p class="small text-muted mb-0">{{ $workout->description }}</p>
                                                @endif
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">Aucune séance définie pour ce programme.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informations</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <strong>Durée:</strong> {{ $program->duration_weeks }} semaines
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chart-line text-primary me-2"></i>
                            <strong>Niveau:</strong> {{ $program->difficulty_level }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-dumbbell text-primary me-2"></i>
                            <strong>Séances:</strong> {{ $program->workouts->count() }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-primary me-2"></i>
                            <strong>Coach:</strong> {{ $program->user->name }}
                        </li>
                    </ul>
                    <hr>
                    <a href="{{ route('programs.user') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-arrow-left me-1"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
</style>
@endsection