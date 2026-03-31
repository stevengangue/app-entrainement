@extends('layouts.app')

@section('title', 'Tableau de bord Admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>Bonjour {{ Auth::user()->name }} ! 👑</h2>
                            <p class="mb-0">Tableau de bord Administrateur - Gérez tous les utilisateurs et programmes</p>
                        </div>
                        <i class="fas fa-crown fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-4 text-primary">{{ $stats['total_users'] }}</h1>
                    <p class="text-muted mb-0">Total Utilisateurs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-4 text-success">{{ $stats['total_coaches'] }}</h1>
                    <p class="text-muted mb-0">Coachs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-4 text-info">{{ $stats['total_athletes'] }}</h1>
                    <p class="text-muted mb-0">Athlètes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-4 text-warning">{{ $stats['total_programs'] }}</h1>
                    <p class="text-muted mb-0">Programmes</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Derniers utilisateurs</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Date</th><th>Actions</th></tr>
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
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Créer un utilisateur
                        </a>
                        <a href="{{ route('admin.coaches') }}" class="btn btn-info btn-lg text-white">
                            <i class="fas fa-chalkboard-user me-2"></i>Gérer les coachs
                        </a>
                        <a href="{{ route('admin.athletes') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-running me-2"></i>Gérer les athlètes
                        </a>
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-users me-2"></i>Tous les utilisateurs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-danger {
        background: linear-gradient(135deg, #f093fb, #f5576c);
    }
</style>
@endsection