<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Performance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function generateMonthlyReport()
    {
        $user = Auth::user();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
        
        $performances = Performance::where('user_id', $user->id)
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->with('exercise')
            ->get();
        
        $stats = [
            'total_workouts' => $performances->count(),
            'total_exercises' => $performances->groupBy('exercise_id')->count(),
            'total_weight' => $performances->sum('weight_used'),
            'total_duration' => $performances->sum('duration_seconds'),
            'best_performance' => $performances->sortByDesc('weight_used')->first(),
            'most_frequent_exercise' => $performances->groupBy('exercise_id')
                ->sortByDesc(function($group) {
                    return $group->count();
                })->first(),
        ];
        
        $pdf = PDF::loadView('reports.monthly', compact('user', 'performances', 'stats', 'monthStart', 'monthEnd'));
        
        return $pdf->download('rapport-mensuel-' . Carbon::now()->format('Y-m') . '.pdf');
    }
    
    public function generateWorkoutReport($workoutId)
    {
        $user = Auth::user();
        $performances = Performance::where('user_id', $user->id)
            ->where('workout_id', $workoutId)
            ->with('exercise')
            ->orderBy('date')
            ->get();
        
        $progressions = [];
        foreach ($performances->groupBy('exercise_id') as $exerciseId => $sessions) {
            $exercise = $sessions->first()->exercise;
            $progressions[$exercise->name] = [
                'initial' => $sessions->first()->weight_used,
                'current' => $sessions->last()->weight_used,
                'improvement' => $sessions->last()->weight_used - $sessions->first()->weight_used,
                'sessions' => $sessions->count()
            ];
        }
        
        $pdf = PDF::loadView('reports.workout', compact('performances', 'progressions'));
        
        return $pdf->download('rapport-seance-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }
}