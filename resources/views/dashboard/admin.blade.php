@extends('layouts.app')

@section('title', 'Tableau de bord Administrateur')

@section('content')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    
    .stat-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 16px;
        padding: 1.5rem;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: rgba(255,255,255,0.5);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1;
    }
    
    .stat-label {
        font-size: 0.85rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 1.5rem;
        border: none;
    }
    
    .card-header h5 {
        margin: 0;
        font-weight: 600;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        border-top: none;
        border-bottom: 2px solid #e9ecef;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .table tbody td {
        vertical-align: middle;
        padding: 1rem;
    }
    
    .badge {
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .badge.bg-danger {
        background: linear-gradient(135deg, #f093fb, #f5576c) !important;
    }
    
    .badge.bg-primary {
        background: linear-gradient(135deg, #4facfe, #00f2fe) !important;
    }
    
    .badge.bg-success {
        background: linear-gradient(135deg, #43e97b, #38f9d7) !important;
    }
    
    @media (max-width: 768px) {
        .stat-number {
            font-size: 1.8rem;
        }
        
        .stat-label {
            font-size: 0.75rem;
        }
        
        .card-header h5 {
            font-size: 1.1rem;
        }
        
        .table thead th {
            font-size: 0.7rem;
        }
        
        .table tbody td {
            font-size: 0.85rem;
            padding: 0.75rem;
        }
    }
    
    @media (max-width: 576px) {
        .stat-card {
            padding: 1rem;
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
        
        .stat-label {
            font-size: 0.7rem;
        }
    }
</style>

<div class="container py-4">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h2 class="mb-1">Bonjour, {{ Auth::user()->name }} ! 👋</h2>
                            <p class="mb-0 opacity-75">Bienvenue sur le tableau de bord administrateur de FitTrack Pro.</p>
                        </div>
                        <div class="mt-2 mt-sm-0">
                            <i class="fas fa-chart-line fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4 g-3">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <div class="stat-number">{{ number_format($stats['total_users']) }}</div>
                <div class="stat-label">Utilisateurs totaux</div>
                <i class="fas fa-users fa-2x position-absolute bottom-0 end-0 opacity-25 me-3 mb-3"></i>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <div class="stat-number">{{ number_format($stats['total_coaches']) }}</div>
                <div class="stat-label">Coachs certifiés</div>
                <i class="fas fa-chalkboard-user fa-2x position-absolute bottom-0 end-0 opacity-25 me-3 mb-3"></i>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                <div class="stat-number">{{ number_format($stats['total_athletes']) }}</div>
                <div class="stat-label">Athlètes actifs</div>
                <i class="fas fa-running fa-2x position-absolute bottom-0 end-0 opacity-25 me-3 mb-3"></i>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                <div class="stat-number">{{ number_format($stats['total_programs']) }}</div>
                <div class="stat-label">Programmes créés</div>
                <i class="fas fa-calendar-alt fa-2x position-absolute bottom-0 end-0 opacity-25 me-3 mb-3"></i>
            </div>
        </div>
    </div>

    <!-- Derniers utilisateurs -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0">
                            <i class="fas fa-users me-2"></i>
                            Derniers utilisateurs inscrits
                        </h5>
                        <div class="mt-2 mt-sm-0">
                            <span class="badge bg-primary">{{ count($recentUsers) }} nouveaux</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Date d'inscription</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-placeholder me-2" style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <strong>{{ $user->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->hasRole('admin'))
                                            <span class="badge bg-danger">Administrateur</span>
                                        @elseif($user->hasRole('coach'))
                                            <span class="badge bg-primary">Coach</span>
                                        @else
                                            <span class="badge bg-success">Athlète</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-alt me-1 text-muted"></i>
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Actif</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Aucun utilisateur récent
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($recentUsers) > 0)
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Affichage des {{ count($recentUsers) }} derniers utilisateurs
                        </small>
                        <a href="#" class="text-decoration-none">
                            Voir tous <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection