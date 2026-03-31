@extends('layouts.app')

@section('title', 'Mes Programmes')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h2>Mes Programmes d'entraînement</h2>
                    <p class="mb-0">Suivez vos progrès et restez motivé !</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Programmes actifs -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="text-white mb-3">
                <i class="fas fa-play-circle me-2"></i>Programmes en cours
            </h3>
        </div>
        
        @forelse($activePrograms as $program)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title text-primary">{{ $program->name }}</h5>
                            <span class="badge bg-success">En cours</span>
                        </div>
                        <p class="card-text text-muted">{{ Str::limit($program->description, 100) }}</p>
                        <div class="mb-2">
                            <span class="badge bg-info">{{ $program->difficulty_level }}</span>
                            <span class="badge bg-secondary">{{ $program->duration_weeks }} semaines</span>
                        </div>
                        @if($program->pivot)
                            <div class="small text-muted mb-3">
                                <i class="fas fa-calendar-alt me-1"></i>
                                Début: {{ \Carbon\Carbon::parse($program->pivot->start_date)->format('d/m/Y') }}
                            </div>
                        @endif
                        <div class="progress mb-3" style="height: 5px;">
                            @php
                                $start = \Carbon\Carbon::parse($program->pivot->start_date);
                                $end = \Carbon\Carbon::parse($program->pivot->end_date);
                                $total = $start->diffInDays($end);
                                $passed = min($total, $start->diffInDays(now()));
                                $progress = $total > 0 ? ($passed / $total) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                        </div>
                        <a href="{{ route('programs.show', $program->id) }}" class="btn btn-primary btn-sm w-100">
                            Voir le programme
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p>Aucun programme actif pour le moment.</p>
                    <a href="{{ route('programs.user') }}#available" class="btn btn-primary">
                        Découvrir des programmes
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Programmes terminés -->
    @if($completedPrograms->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="text-white mb-3">
                <i class="fas fa-check-circle me-2"></i>Programmes terminés
            </h3>
        </div>
        
        @foreach($completedPrograms as $program)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card bg-light h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title">{{ $program->name }}</h5>
                            <span class="badge bg-secondary">Terminé</span>
                        </div>
                        <p class="card-text text-muted">{{ Str::limit($program->description, 100) }}</p>
                        <div class="mb-2">
                            <span class="badge bg-info">{{ $program->difficulty_level }}</span>
                            <span class="badge bg-secondary">{{ $program->duration_weeks }} semaines</span>
                        </div>
                        <a href="{{ route('programs.show', $program->id) }}" class="btn btn-outline-secondary btn-sm w-100">
                            Voir le programme
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif

    <!-- Programmes disponibles -->
    <div id="available" class="row">
        <div class="col-12">
            <h3 class="text-white mb-3">
                <i class="fas fa-dumbbell me-2"></i>Programmes disponibles
            </h3>
        </div>
        
        @forelse($availablePrograms as $program)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-primary">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $program->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($program->description, 100) }}</p>
                        <div class="mb-2">
                            <span class="badge bg-info">{{ $program->difficulty_level }}</span>
                            <span class="badge bg-secondary">{{ $program->duration_weeks }} semaines</span>
                        </div>
                        <p class="small text-muted">
                            <i class="fas fa-user me-1"></i>Coach: {{ $program->user->name }}
                        </p>
                        <form action="{{ route('programs.enroll', $program->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm w-100">
                                <i class="fas fa-plus me-1"></i>S'inscrire
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary text-center">
                    <i class="fas fa-search fa-2x mb-2"></i>
                    <p>Aucun programme disponible pour le moment.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

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
@endsection