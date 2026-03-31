<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    /**
     * Afficher les programmes de l'utilisateur connecté
     */
    public function userPrograms()
    {
        $user = Auth::user();
        
        // Récupérer tous les programmes assignés à l'utilisateur
        $allPrograms = $user->assignedPrograms()
            ->with(['workouts', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Séparer les programmes actifs et terminés
        $activePrograms = $allPrograms->filter(function($program) {
            return $program->pivot->status === 'active';
        });
        
        $completedPrograms = $allPrograms->filter(function($program) {
            return $program->pivot->status === 'completed';
        });
        
        // Programmes publics disponibles
        $availablePrograms = Program::where('is_public', true)
            ->whereDoesntHave('users', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
        
        return view('programs.user', compact('activePrograms', 'completedPrograms', 'availablePrograms'));
    }
    
    /**
     * Afficher les détails d'un programme
     */
    public function show($id)
    {
        $program = Program::with(['workouts', 'user'])->findOrFail($id);
        
        // Vérifier que l'utilisateur a accès à ce programme
        $user = Auth::user();
        
        // Les admins et coachs peuvent tout voir
        if ($user->hasRole('admin') || $user->hasRole('coach')) {
            return view('programs.show', compact('program'));
        }
        
        // Les athlètes ne voient que leurs programmes assignés
        if (!$user->assignedPrograms()->where('program_id', $id)->exists()) {
            abort(403, 'Vous n\'avez pas accès à ce programme');
        }
        
        return view('programs.show', compact('program'));
    }
    
    /**
     * Afficher les séances d'un programme
     */
    public function workouts($id)
    {
        $program = Program::with(['workouts.exercises'])->findOrFail($id);
        
        $user = Auth::user();
        
        // Vérifier l'accès
        if (!$user->hasRole('admin') && !$user->hasRole('coach')) {
            if (!$user->assignedPrograms()->where('program_id', $id)->exists()) {
                abort(403);
            }
        }
        
        return view('programs.workouts', compact('program'));
    }
    
    /**
     * Afficher la progression de l'athlète sur un programme
     */
    public function progress($id)
    {
        $program = Program::findOrFail($id);
        $user = Auth::user();
        
        // Vérifier l'accès
        if (!$user->assignedPrograms()->where('program_id', $id)->exists() && !$user->hasRole('admin') && !$user->hasRole('coach')) {
            abort(403);
        }
        
        // Récupérer les performances de l'athlète pour ce programme
        $performances = Performance::where('user_id', $user->id)
            ->whereHas('workout', function($query) use ($program) {
                $query->where('program_id', $program->id);
            })
            ->with(['exercise', 'workout'])
            ->orderBy('date', 'desc')
            ->get();
        
        // Calculer les statistiques de progression
        $stats = [
            'total_workouts' => $program->workouts->count(),
            'completed_workouts' => $performances->groupBy('workout_id')->count(),
            'total_performances' => $performances->count(),
            'best_performance' => $performances->sortByDesc('weight_used')->first(),
        ];
        
        return view('programs.progress', compact('program', 'performances', 'stats'));
    }
    
    /**
     * S'inscrire à un programme public
     */
    public function enroll(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        $user = Auth::user();
        
        // Vérifier que c'est un athlète
        if (!$user->hasRole('user')) {
            return back()->with('error', 'Seuls les athlètes peuvent s\'inscrire à des programmes');
        }
        
        // Vérifier que le programme est public
        if (!$program->is_public) {
            return back()->with('error', 'Ce programme n\'est pas public');
        }
        
        // Vérifier que l'athlète n'est pas déjà inscrit
        if ($user->assignedPrograms()->where('program_id', $id)->exists()) {
            return back()->with('error', 'Vous êtes déjà inscrit à ce programme');
        }
        
        // Inscrire l'athlète au programme
        $user->assignedPrograms()->attach($program->id, [
            'start_date' => now(),
            'end_date' => now()->addWeeks($program->duration_weeks),
            'status' => 'active'
        ]);
        
        return redirect()->route('programs.user')->with('success', 'Inscription au programme réussie !');
    }
    
    /**
     * Marquer une séance comme terminée
     */
    public function completeWorkout(Request $request, $programId, $workoutId)
    {
        $user = Auth::user();
        
        // Vérifier que l'athlète a accès à ce programme
        if (!$user->assignedPrograms()->where('program_id', $programId)->exists()) {
            abort(403);
        }
        
        // Logique pour marquer la séance comme terminée
        // À implémenter selon vos besoins
        
        return back()->with('success', 'Séance marquée comme terminée !');
    }
}