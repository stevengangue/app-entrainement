@extends('layouts.app')

@section('title', 'Statistiques')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h2>Mes Statistiques</h2>
                    <p class="mb-0">Analysez votre progression</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Progression par exercice</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Exercice</th>
                                    <th>Séances</th>
                                    <th>Poids max (kg)</th>
                                    <th>Poids moyen (kg)</th>
                                    <th>Séries moy.</th>
                                    <th>Rép. moy.</th>
                                </thead>
                            <tbody>
                                @foreach($exerciseStats as $stat)
                                <tr>
                                    <td><strong>{{ $stat->exercise->name }}</strong></td>
                                    <td>{{ $stat->total_sessions }}</td>
                                    <td>{{ number_format($stat->max_weight, 1) }}</td>
                                    <td>{{ number_format($stat->avg_weight, 1) }}</td>
                                    <td>{{ number_format($stat->avg_sets, 1) }}</td>
                                    <td>{{ number_format($stat->avg_reps, 1) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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