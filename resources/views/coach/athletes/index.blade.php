@extends('layouts.app')

@section('title', 'Mes Athlètes')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">👥 Mes Athlètes</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @forelse($athletes as $athlete)
                        <div class="border rounded p-3 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="mb-1">{{ $athlete->name }}</h4>
                                    <p class="text-muted mb-1">{{ $athlete->email }}</p>
                                    <p class="small text-muted mb-0">
                                        Inscrit le {{ $athlete->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{ url('/coach/athletes/' . $athlete->id) }}" class="btn btn-primary">
                                        <i class="fas fa-chart-line"></i> Voir progression
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-4x text-muted mb-3"></i>
                            <h4>Aucun athlète</h4>
                            <p class="text-muted">Vous n'avez pas encore d'athlètes assignés.</p>
                            <small class="text-muted">Les athlètes doivent être assignés par l'administrateur.</small>
                        </div>
                    @endforelse

                    {{ $athletes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection