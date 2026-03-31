@extends('layouts.app')

@section('title', 'Tableau de bord Administrateur')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h2>Bonjour, {{ Auth::user()->name }} ! 👋</h2>
                    <p>Bienvenue sur le tableau de bord administrateur de FitTrack Pro.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Utilisateurs</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <div class="stat-number">{{ $stats['total_coaches'] }}</div>
                <div class="stat-label">Coachs</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                <div class="stat-number">{{ $stats['total_athletes'] }}</div>
                <div class="stat-label">Athlètes</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                <div class="stat-number">{{ $stats['total_programs'] }}</div>
                <div class="stat-label">Programmes</div>
            </div>
        </div>
    </div>

    <!-- Derniers utilisateurs -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">👥 Derniers utilisateurs inscrits</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                             <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Date d'inscription</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->hasRole('admin'))
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($user->hasRole('coach'))
                                        <span class="badge bg-primary">Coach</span>
                                    @else
                                        <span class="badge bg-success">Athlète</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
</style>
@endpush
@endsection