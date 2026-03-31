@extends('layouts.app')

@section('title', 'Tableau de bord - FitTrack Pro')

@section('content')
<div class="dashboard-container">
    <!-- Hero Section -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="display-4 fw-bold mb-3">
                                Bonjour, {{ Auth::user()->name }}! 👋
                            </h1>
                            <p class="lead mb-4">
                                Prêt à atteindre de nouveaux sommets aujourd'hui ? 
                                Vous êtes à <strong>{{ $stats['current_streak'] }}</strong> jours de série !
                            </p>
                            <a href="{{ route('performances.create') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-plus-circle me-2"></i>Enregistrer une séance
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-running fa-5x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-5">
        <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $stats['total_workouts'] }}</div>
                        <div class="stat-label">Séances totales</div>
                    </div>
                    <i class="fas fa-dumbbell fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $stats['total_exercises'] }}</div>
                        <div class="stat-label">Exercices différents</div>
                    </div>
                    <i class="fas fa-heartbeat fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $stats['total_days'] }}</div>
                        <div class="stat-label">Jours actifs</div>
                    </div>
                    <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $stats['current_streak'] }}</div>
                        <div class="stat-label">Jours de série 🔥</div>
                    </div>
                    <i class="fas fa-fire fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Workouts and Progress Chart -->
    <div class="row mb-5">
        <div class="col-lg-8 mb-4" data-aos="fade-right">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-line me-2"></i>Progression des 30 derniers jours
                </div>
                <div class="card-body">
                    <canvas id="performanceChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4" data-aos="fade-left">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-medal me-2"></i>Top Exercices
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($topExercises as $exercise)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-dumbbell me-2 text-primary"></i>
                                    {{ $exercise->exercise->name }}
                                </div>
                                <span class="badge bg-primary rounded-pill">{{ $exercise->total }} séances</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Programs -->
    @if($activePrograms->count() > 0)
    <div class="row mb-5">
        <div class="col-12" data-aos="fade-up">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-calendar-alt me-2"></i>Programmes Actifs
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($activePrograms as $program)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="program-card">
                                    <div class="program-header">
                                        <h5 class="mb-1">{{ $program->name }}</h5>
                                        <span class="badge bg-{{ $program->difficulty_level == 'Débutant' ? 'success' : ($program->difficulty_level == 'Intermédiaire' ? 'warning' : 'danger') }}">
                                            {{ $program->difficulty_level }}
                                        </span>
                                    </div>
                                    <p class="text-muted small mt-2">{{ Str::limit($program->description, 100) }}</p>
                                    <div class="progress mb-2">
                                        @php
                                            $daysPassed = \Carbon\Carbon::parse($program->pivot->start_date)->diffInDays(now());
                                            $totalDays = \Carbon\Carbon::parse($program->pivot->start_date)->diffInDays(\Carbon\Carbon::parse($program->pivot->end_date));
                                            $progress = min(100, ($daysPassed / $totalDays) * 100);
                                        @endphp
                                        <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span><i class="fas fa-calendar me-1"></i>Semaine {{ ceil($daysPassed / 7) }}/{{ $program->duration_weeks }}</span>
                                        <span><i class="fas fa-check-circle me-1"></i>{{ floor($progress) }}%</span>
                                    </div>
                                    <a href="{{ route('programs.show', $program) }}" class="btn btn-sm btn-outline-primary mt-3 w-100">
                                        Voir le programme <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Weekly Goals -->
    <div class="row">
        <div class="col-12" data-aos="fade-up">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bullseye me-2"></i>Objectifs de la semaine
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($weeklyGoals as $goal)
                            <div class="col-md-4 mb-3">
                                <div class="goal-item">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-bold">{{ $goal['name'] }}</span>
                                        <span>{{ $goal['current'] }}/{{ $goal['target'] }} {{ $goal['unit'] }}</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ min(100, ($goal['current'] / $goal['target']) * 100) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Performance Chart
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const performanceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($performanceProgress['labels']) !!},
            datasets: [{
                label: 'Séances par jour',
                data: {!! json_encode($performanceProgress['data']) !!},
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#4361ee',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#4361ee',
                    borderWidth: 2
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endpush

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .program-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }
    
    .program-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    
    .goal-item {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1rem;
    }
    
    .opacity-50 {
        opacity: 0.5;
    }
    
    .list-group-item {
        border: none;
        padding: 0.75rem 0;
    }
    
    .list-group-item:first-child {
        padding-top: 0;
    }
    
    .list-group-item:last-child {
        padding-bottom: 0;
    }
</style>
@endpush
@endsection