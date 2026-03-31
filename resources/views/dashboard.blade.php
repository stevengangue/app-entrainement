@extends('layouts.app')

@section('title', 'Tableau de bord - FitTrack Pro')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Bienvenue, {{ Auth::user()->name }} !</h3>
                </div>
                <div class="card-body">
                    <p>Votre tableau de bord est en cours de construction.</p>
                    <p>Vous êtes connecté en tant que : 
                        <strong>{{ Auth::user()->hasRole('admin') ? 'Administrateur' : (Auth::user()->hasRole('coach') ? 'Coach' : 'Utilisateur') }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection