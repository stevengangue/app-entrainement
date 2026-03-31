@extends('layouts.app')

@section('title', 'Mes Programmes')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">📋 Mes Programmes d'entraînement</h3>
                        <a href="{{ url('/coach/programs/create') }}" class="btn btn-light">
                            <i class="fas fa-plus"></i> Nouveau programme
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @forelse($programs as $program)
                        <div class="border rounded p-3 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="mb-1">{{ $program->name }}</h4>
                                    <p class="text-muted mb-2">{{ Str::limit($program->description, 150) }}</p>
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $program->difficulty_level }}</span>
                                        <span class="badge bg-info">{{ $program->duration_weeks }} semaines</span>
                                        @if($program->is_public)
                                            <span class="badge bg-success">Public</span>
                                        @else
                                            <span class="badge bg-secondary">Privé</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{ url('/coach/programs/' . $program->id . '/edit') }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <form action="{{ url('/coach/programs/' . $program->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce programme ?')">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-dumbbell fa-4x text-muted mb-3"></i>
                            <h4>Aucun programme</h4>
                            <p class="text-muted">Vous n'avez pas encore créé de programme d'entraînement.</p>
                            <a href="{{ url('/coach/programs/create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus"></i> Créer mon premier programme
                            </a>
                        </div>
                    @endforelse

                    @if(method_exists($programs, 'links'))
                        <div class="mt-4">
                            {{ $programs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .badge {
        font-size: 0.8rem;
        padding: 5px 10px;
    }
    .border {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .border:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>
@endsection