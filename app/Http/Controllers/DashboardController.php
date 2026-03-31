<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Program;
use App\Models\Performance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('coach')) {
            return $this->coachDashboard();
        } elseif ($user->hasRole('user')) {
            return $this->athleteDashboard();
        }

        return view('dashboard');
    }

    private function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_coaches' => User::role('coach')->count(),
            'total_athletes' => User::role('user')->count(),
            'total_programs' => Program::count(),
            'total_performances' => Performance::count(),
        ];

        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();
        
        return view('dashboard.admin', compact('stats', 'recentUsers'));
    }

    private function coachDashboard()
    {
        $user = Auth::user();
        
        $athletes = $user->athletes()->get();
        $programs = Program::where('user_id', $user->id)->withCount('users')->get();
        
        $stats = [
            'total_athletes' => $athletes->count(),
            'total_programs' => $programs->count(),
            'total_sessions' => 0,
            'upcoming_sessions' => 0,
        ];
        
        return view('dashboard.coach', compact('athletes', 'programs', 'stats'));
    }

    private function athleteDashboard()
    {
        $user = Auth::user();
        
        // Récupérer TOUS les programmes assignés à l'athlète
        $assignedPrograms = $user->assignedPrograms()
            ->with(['workouts', 'user'])
            ->get();
        
        // Compter les programmes par statut
        $activePrograms = $assignedPrograms->filter(function($program) {
            return $program->pivot->status === 'active';
        });
        
        $completedPrograms = $assignedPrograms->filter(function($program) {
            return $program->pivot->status === 'completed';
        });
        
        // Récupérer les performances récentes (5 dernières)
        $recentPerformances = $user->performances()
            ->with('exercise')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
        
        // Calculer le total des performances
        $totalPerformances = $user->performances()->count();
        
        // Récupérer le coach de l'athlète
        $coach = $user->coach;
        
        // Calculer la progression globale (pourcentage de programmes complétés)
        $totalPrograms = $assignedPrograms->count();
        $completedCount = $completedPrograms->count();
        $globalProgress = $totalPrograms > 0 ? round(($completedCount / $totalPrograms) * 100) : 0;
        
        // Calculer les statistiques des dernières performances
        $lastWeekPerformances = $user->performances()
            ->where('date', '>=', Carbon::now()->subDays(7))
            ->count();
        
        $bestPerformance = $user->performances()
            ->with('exercise')
            ->orderBy('weight_used', 'desc')
            ->first();
        
        // Calculer le nombre de séances réalisées cette semaine
        $workoutsThisWeek = $user->performances()
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
        
        $stats = [
            'total_programs' => $totalPrograms,
            'active_programs' => $activePrograms->count(),
            'completed_programs' => $completedPrograms->count(),
            'total_performances' => $totalPerformances,
            'last_week_performances' => $lastWeekPerformances,
            'workouts_this_week' => $workoutsThisWeek,
            'global_progress' => $globalProgress,
            'coach_name' => $coach ? $coach->name : 'Aucun coach assigné',
            'best_performance' => $bestPerformance,
        ];
        
        return view('dashboard.athlete', compact('activePrograms', 'completedPrograms', 'recentPerformances', 'stats'));
    }
}