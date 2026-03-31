@extends('layouts.app')

@section('title', 'Tableau de bord Athlète')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>Bonjour {{ Auth::user()->name }} ! 💪</h2>
                            <p class="mb-0">
                                <i class="fas fa-chalkboard-user me-1"></i>
                                Coach : <strong>{{ $stats['coach_name'] }}</strong>
                            </p>
                        </div>
                        <div class="text-end">
                            <div class="display-6 fw-bold">{{ $stats['global_progress'] }}%</div>
                            <small>Progression globale</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <div class="stat-number">{{ $stats['total_programs'] }}</div>
                <div class="stat-label">Programmes</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #4caf50, #45a049);">
                <div class="stat-number">{{ $stats['active_programs'] }}</div>
                <div class="stat-label">En cours</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #ff9800, #f57c00);">
                <div class="stat-number">{{ $stats['completed_programs'] }}</div>
                <div class="stat-label">Terminés</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #f44336, #d32f2f);">
                <div class="stat-number">{{ $stats['total_performances'] }}</div>
                <div class="stat-label">Performances</div>
            </div>
        </div>
    </div>

    <!-- Statistiques secondaires -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">Séances cette semaine</p>
                            <h3 class="mb-0">{{ $stats['workouts_this_week'] }}</h3>
                        </div>
                        <i class="fas fa-calendar-week fa-3x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">Performances (7 derniers jours)</p>
                            <h3 class="mb-0">{{ $stats['last_week_performances'] }}</h3>
                        </div>
                        <i class="fas fa-chart-line fa-3x text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barre de progression globale -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Progression globale</span>
                        <span><strong>{{ $stats['global_progress'] }}%</strong></span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: {{ $stats['global_progress'] }}%"></div>
                    </div>
                    <div class="small text-muted mt-2">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        {{ $stats['completed_programs'] }} programme(s) terminé(s) sur {{ $stats['total_programs'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Programmes actifs -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-play-circle me-2"></i>Programmes en cours</h5>
                </div>
                <div class="card-body">
                    @forelse($activePrograms as $program)
                        <div class="program-item mb-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ $program->name }}</h6>
                                    <p class="small text-muted mb-2">{{ Str::limit($program->description, 80) }}</p>
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $program->difficulty_level }}</span>
                                        <span class="badge bg-info">{{ $program->duration_weeks }} sem</span>
                                    </div>
                                    @if($program->pivot)
                                        @php
                                            $start = \Carbon\Carbon::parse($program->pivot->start_date);
                                            $end = \Carbon\Carbon::parse($program->pivot->end_date);
                                            $total = $start->diffInDays($end);
                                            $passed = min($total, $start->diffInDays(now()));
                                            $progress = $total > 0 ? ($passed / $total) * 100 : 0;
                                        @endphp
                                        <div class="progress mb-2" style="height: 4px;">
                                            <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ floor($progress) }}% complété
                                        </div>
                                    @endif
                                </div>
                                <span class="badge bg-success ms-2">En cours</span>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('programs.show', $program->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-dumbbell fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucun programme actif</p>
                            <a href="{{ route('programs.user') }}" class="btn btn-primary btn-sm">
                                Découvrir des programmes
                            </a>
                        </div>
                    @endforelse
                    
                    @if($activePrograms->count() > 0)
                        <div class="text-center mt-2">
                            <a href="{{ route('programs.user') }}" class="btn btn-link btn-sm">
                                Voir tous mes programmes
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Performances récentes -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Dernières performances</h5>
                    <a href="{{ route('performances.create') }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus"></i> Ajouter
                    </a>
                </div>
                <div class="card-body">
                    @if($recentPerformances->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Exercice</th>
                                        <th>Séries</th>
                                        <th>Rép.</th>
                                        <th>Poids</th>
                                    </thead>
                                <tbody>
                                    @foreach($recentPerformances as $perf)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($perf->date)->format('d/m') }}</td>
                                        <td><strong>{{ $perf->exercise->name ?? 'N/A' }}</strong></td>
                                        <td>{{ $perf->sets_completed }}</td>
                                        <td>{{ $perf->reps_completed }}</td>
                                        <td>{{ $perf->weight_used ?? '-' }} kg</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-2">
                            <a href="{{ route('performances.index') }}" class="btn btn-sm btn-outline-primary">
                                Voir toutes mes performances
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucune performance enregistrée</p>
                            <a href="{{ route('performances.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Enregistrer
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Meilleure performance -->
    @if($stats['best_performance'])
    <div class="row">
        <div class="col-12">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">🏆 Record personnel</h5>
                            <p class="mb-0">
                                <strong>{{ $stats['best_performance']->exercise->name ?? 'Exercice' }}</strong> - 
                                {{ $stats['best_performance']->weight_used }} kg
                                @if($stats['best_performance']->reps_completed)
                                    ({{ $stats['best_performance']->reps_completed }} répétitions)
                                @endif
                            </p>
                            <small class="text-dark">
                                {{ \Carbon\Carbon::parse($stats['best_performance']->date)->format('d/m/Y') }}
                            </small>
                        </div>
                        <i class="fas fa-trophy fa-3x text-dark opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    .stat-card {
        border-radius: 15px;
        padding: 1.2rem;
        color: white;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
    }
    .stat-number {
        font-size: 1.8rem;
        font-weight: bold;
    }
    .stat-label {
        font-size: 0.8rem;
        opacity: 0.9;
    }
    .program-item {
        transition: all 0.2s;
    }
    .program-item:hover {
        background: #f8f9fa;
    }
    .table td, .table th {
        padding: 0.5rem;
    }
</style>
@endsection