@extends('layouts.app')

@section('title', 'Gestion des coachs')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-chalkboard-user me-2"></i>Liste des coachs</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>Ajouter un coach
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($coaches as $coach)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ $coach->name }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2">{{ $coach->email }}</p>
                        <p class="mb-2">
                            <i class="fas fa-users me-2"></i>
                            <strong>{{ $coach->athletes->count() }}</strong> athlète(s) assigné(s)
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-dumbbell me-2"></i>
                            <strong>{{ $coach->programs->count() }}</strong> programme(s) créé(s)
                        </p>
                        <p class="small text-muted">Inscrit le {{ $coach->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="btn-group w-100">
                            <a href="{{ route('admin.users.edit', $coach) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <button class="btn btn-sm btn-info" onclick="showAthletes({{ $coach->id }}, '{{ $coach->name }}')">
                                <i class="fas fa-users"></i> {{ $coach->athletes->count() }} athlètes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Aucun coach pour le moment</div>
            </div>
        @endforelse
    </div>
    {{ $coaches->links() }}
</div>
@endsection