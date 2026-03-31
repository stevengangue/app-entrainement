@extends('layouts.app')

@section('title', 'Gestion des athlètes')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-running me-2"></i>Liste des athlètes</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>Ajouter un athlète
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Coach assigné</th>
                            <th>Programmes</th>
                            <th>Performances</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($athletes as $athlete)
                        <tr>
                            <td>{{ $athlete->name }}</td>
                            <td>{{ $athlete->email }}</td>
                            <td>
                                @if($athlete->coach)
                                    {{ $athlete->coach->name }}
                                @else
                                    <form action="{{ route('admin.athletes.assign-coach', $athlete) }}" method="POST" class="d-flex">
                                        @csrf
                                        <select name="coach_id" class="form-select form-select-sm me-2" style="width: auto;" required>
                                            <option value="">Assigner un coach</option>
                                            @foreach(\App\Models\User::role('coach')->get() as $coach)
                                                <option value="{{ $coach->id }}">{{ $coach->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary">Assigner</button>
                                    </form>
                                @endif
                            </td>
                            <td><span class="badge bg-info">{{ $athlete->assignedPrograms->count() }}</span></td>
                            <td><span class="badge bg-success">{{ $athlete->performances->count() }}</span></td>
                            <td>
                                <a href="{{ route('admin.users.edit', $athlete) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.delete', $athlete) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">{{ $athletes->links() }}</div>
</div>
@endsection