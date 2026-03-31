@extends('layouts.app')

@section('title', 'Mes Performances')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>Mes Performances</h2>
                            <p class="mb-0">Suivez votre progression et battez vos records</p>
                        </div>
                        <a href="{{ route('performances.create') }}" class="btn btn-light">
                            <i class="fas fa-plus"></i> Nouvelle performance
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary">{{ $stats['total'] }}</h3>
                    <p class="text-muted mb-0">Séances totales</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success">{{ $stats['this_week'] }}</h3>
                    <p class="text-muted mb-0">Cette semaine</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning">{{ number_format($stats['total_weight']) }} kg</h3>
                    <p class="text-muted mb-0">Poids total soulevé</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des performances -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Historique des séances</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Exercice</th>
                            <th>Séries</th>
                            <th>Répétitions</th>
                            <th>Poids (kg)</th>
                            <th>Durée</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </thead>
                    <tbody>
                        @forelse($performances as $perf)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($perf->date)->format('d/m/Y') }}</td>
                            <td><strong>{{ $perf->exercise->name ?? 'N/A' }}</strong></td>
                            <td>{{ $perf->sets_completed }}</td>
                            <td>{{ $perf->reps_completed }}</td>
                            <td>{{ $perf->weight_used ?? '-' }}</td>
                            <td>
                                @if($perf->duration_seconds)
                                    {{ floor($perf->duration_seconds / 60) }}min {{ $perf->duration_seconds % 60 }}s
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($perf->notes)
                                    <span class="badge bg-info" data-bs-toggle="tooltip" title="{{ $perf->notes }}">
                                        <i class="fas fa-comment"></i>
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('performances.edit', $perf) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('performances.destroy', $perf) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette performance ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucune performance enregistrée</p>
                                <a href="{{ route('performances.create') }}" class="btn btn-primary">
                                    Enregistrer ma première performance
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($performances->hasPages())
        <div class="card-footer">
            {{ $performances->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
</style>
@endsection