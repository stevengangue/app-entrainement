<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\Admin\ExerciseController;
use App\Http\Controllers\Admin\ProgramController;
use Illuminate\Support\Facades\Route;
Route::get('/test-simple', function() {
    return '<h1>Le serveur fonctionne !</h1><p>Heure: ' . date('H:i:s') . '</p>';
});
// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification
Auth::routes();

// Routes protégées
Route::middleware(['auth'])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Performances
    Route::resource('performances', PerformanceController::class);
    Route::get('performance-stats', [PerformanceController::class, 'stats'])->name('performances.stats');
    
    // Programmes pour les athlètes
    Route::get('my-programs', [ProgramController::class, 'userPrograms'])->name('programs.user');
    
    // Exercices - Bibliothèque publique
    Route::get('exercises/library', [ExerciseController::class, 'library'])->name('exercises.library');
});

// Routes pour les COACHS - CORRECTION ICI
Route::middleware(['auth'])->prefix('coach')->name('coach.')->group(function () {
    // Programmes
    Route::get('programs', [App\Http\Controllers\Coach\ProgramController::class, 'index'])->name('programs.index');
    Route::get('programs/create', [App\Http\Controllers\Coach\ProgramController::class, 'create'])->name('programs.create');
    Route::post('programs', [App\Http\Controllers\Coach\ProgramController::class, 'store'])->name('programs.store');
    Route::get('programs/{program}/edit', [App\Http\Controllers\Coach\ProgramController::class, 'edit'])->name('programs.edit');
    Route::put('programs/{program}', [App\Http\Controllers\Coach\ProgramController::class, 'update'])->name('programs.update');
    Route::delete('programs/{program}', [App\Http\Controllers\Coach\ProgramController::class, 'destroy'])->name('programs.destroy');
    Route::post('programs/{program}/assign', [App\Http\Controllers\Coach\ProgramController::class, 'assign'])->name('programs.assign');
    
    // Athlètes
    Route::get('athletes', [App\Http\Controllers\Coach\AthleteController::class, 'index'])->name('athletes.index');
    Route::get('athletes/{user}', [App\Http\Controllers\Coach\AthleteController::class, 'show'])->name('athletes.show');
    Route::post('athletes/{user}/assign-program', [App\Http\Controllers\Coach\AthleteController::class, 'assignProgram'])->name('athletes.assign-program');
});

// Routes Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('exercises', ExerciseController::class);
    Route::resource('programs', ProgramController::class);
});
// Routes Administrateur
// Routes Administrateur
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users');
    Route::get('/coaches', [App\Http\Controllers\Admin\AdminController::class, 'coaches'])->name('coaches');
    Route::get('/athletes', [App\Http\Controllers\Admin\AdminController::class, 'athletes'])->name('athletes');
    Route::get('/users/create', [App\Http\Controllers\Admin\AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\Admin\AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\AdminController::class, 'deleteUser'])->name('users.delete');
    Route::post('/athletes/{athlete}/assign-coach', [App\Http\Controllers\Admin\AdminController::class, 'assignCoach'])->name('athletes.assign-coach');
});
// Routes pour les programmes (accessible par tous les utilisateurs connectés)
Route::middleware(['auth'])->group(function () {
    Route::get('/my-programs', [App\Http\Controllers\ProgramController::class, 'userPrograms'])->name('programs.user');
    Route::get('/programs/{id}', [App\Http\Controllers\ProgramController::class, 'show'])->name('programs.show');
    Route::post('/programs/{id}/enroll', [App\Http\Controllers\ProgramController::class, 'enroll'])->name('programs.enroll');
    Route::get('/programs/{id}/workouts', [App\Http\Controllers\ProgramController::class, 'workouts'])->name('programs.workouts');
    Route::get('/programs/{id}/progress', [App\Http\Controllers\ProgramController::class, 'progress'])->name('programs.progress');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('performances', App\Http\Controllers\PerformanceController::class);
    Route::get('performance-stats', [App\Http\Controllers\PerformanceController::class, 'stats'])->name('performances.stats');
});