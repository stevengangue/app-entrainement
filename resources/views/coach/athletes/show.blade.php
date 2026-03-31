@extends('layouts.app')

@section('title', 'Profil de ' . $user->name)

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h2>{{ $user->name }}</h2>
                    <p class="mb-0">{{ $user->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>📋 Programmes assignés</h5>
                </div>
                <div class="card-body">
                    @forelse($programs as $program)
                        <div class="border-bottom mb-2 pb-2">
                            <strong>{{ $program->name }}</strong>
                            <p class="small text-muted mb-0">
                                Du {{ \Carbon\Carbon::parse($program->pivot->start_date)->format('d/m/Y') }}
                                au {{ \Carbon\Carbon::parse($program->pivot->end_date)->format('d/m/Y') }}
                                - Statut: <span class="badge bg-{{ $program->pivot->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ $program->pivot->status == 'active' ? 'En cours' : 'Terminé' }}
                                </span>
                            </p>
                        </div>
                    @empty
                        <p class="text-muted text-center">Aucun programme assigné</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>➕ Assigner un programme</h5>
                </div>
                <div class="card-body">
                    @if($availablePrograms->count() > 0)
                        <form action="{{ url('/coach/athletes/' . $user->id . '/assign-program') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Programme</label>
                                <select name="program_id" class="form-select" required>
                                    <option value="">Sélectionner</option>
                                    @foreach($availablePrograms as $program)
                                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date début</label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date fin</label>
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Assigner</button>
                        </form>
                    @else
                        <p class="text-muted text-center">Aucun programme disponible</p>
                        <a href="{{ url('/coach/programs/create') }}" class="btn btn-primary w-100">Créer un programme</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>📊 Performances récentes</h5>
                </div>
                <div class="card-body">
                    @if($performances->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Exercice</th>
                                        <th>Séries</th>
                                        <th>Répétitions</th>
                                        <th>Poids (kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($performances as $perf)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($perf->date)->format('d/m/Y') }}</td>
                                        <td>{{ $perf->exercise->name ?? 'N/A' }}</td>
                                        <td>{{ $perf->sets_completed }}</td>
                                        <td>{{ $perf->reps_completed }}</td>
                                        <td>{{ $perf->weight_used ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">Aucune performance enregistrée</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection