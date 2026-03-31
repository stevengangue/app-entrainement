<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PerformanceController extends Controller
{
    /**
     * Afficher la liste des performances
     */
    public function index()
    {
        $user = Auth::user();
        
        $performances = Performance::where('user_id', $user->id)
            ->with(['exercise', 'workout'])
            ->orderBy('date', 'desc')
            ->paginate(15);
        
        $stats = [
            'total' => $performances->total(),
            'this_week' => Performance::where('user_id', $user->id)
                ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count(),
            'best_exercise' => $this->getBestExercise($user->id),
            'total_weight' => Performance::where('user_id', $user->id)->sum('weight_used'),
        ];
        
        return view('performances.index', compact('performances', 'stats'));
    }
    
    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $exercises = Exercise::orderBy('name')->get();
        $workouts = Workout::all();
        
        return view('performances.create', compact('exercises', 'workouts'));
    }
    
    /**
     * Enregistrer une nouvelle performance
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'workout_id' => 'nullable|exists:workouts,id',
            'sets_completed' => 'required|integer|min:1',
            'reps_completed' => 'required|integer|min:1',
            'weight_used' => 'nullable|numeric|min:0',
            'duration_seconds' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            'date' => 'required|date',
        ]);
        
        $validated['user_id'] = Auth::id();
        
        Performance::create($validated);
        
        return redirect()->route('performances.index')
            ->with('success', 'Performance enregistrée avec succès !');
    }
    
    /**
     * Afficher les détails d'une performance
     */
    public function show(Performance $performance)
    {
        if ($performance->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }
        
        return view('performances.show', compact('performance'));
    }
    
    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Performance $performance)
    {
        if ($performance->user_id !== Auth::id()) {
            abort(403);
        }
        
        $exercises = Exercise::orderBy('name')->get();
        $workouts = Workout::all();
        
        return view('performances.edit', compact('performance', 'exercises', 'workouts'));
    }
    
    /**
     * Mettre à jour une performance
     */
    public function update(Request $request, Performance $performance)
    {
        if ($performance->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'workout_id' => 'nullable|exists:workouts,id',
            'sets_completed' => 'required|integer|min:1',
            'reps_completed' => 'required|integer|min:1',
            'weight_used' => 'nullable|numeric|min:0',
            'duration_seconds' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            'date' => 'required|date',
        ]);
        
        $performance->update($validated);
        
        return redirect()->route('performances.index')
            ->with('success', 'Performance mise à jour avec succès !');
    }
    
    /**
     * Supprimer une performance
     */
    public function destroy(Performance $performance)
    {
        if ($performance->user_id !== Auth::id()) {
            abort(403);
        }
        
        $performance->delete();
        
        return redirect()->route('performances.index')
            ->with('success', 'Performance supprimée avec succès !');
    }
    
    /**
     * Afficher les statistiques
     */
    public function stats()
    {
        $user = Auth::user();
        
        $exerciseStats = Performance::where('user_id', $user->id)
            ->with('exercise')
            ->select('exercise_id', 
                \DB::raw('AVG(weight_used) as avg_weight'),
                \DB::raw('AVG(sets_completed) as avg_sets'),
                \DB::raw('AVG(reps_completed) as avg_reps'),
                \DB::raw('COUNT(*) as total_sessions'),
                \DB::raw('MAX(weight_used) as max_weight'))
            ->groupBy('exercise_id')
            ->get();
        
        $monthlyStats = Performance::where('user_id', $user->id)
            ->where('date', '>=', Carbon::now()->subMonths(3))
            ->select(\DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), 
                \DB::raw('COUNT(*) as total_workouts'),
                \DB::raw('SUM(duration_seconds) as total_duration'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        return view('performances.stats', compact('exerciseStats', 'monthlyStats'));
    }
    
    private function getBestExercise($userId)
    {
        $best = Performance::where('user_id', $userId)
            ->with('exercise')
            ->select('exercise_id', \DB::raw('MAX(weight_used) as max_weight'))
            ->groupBy('exercise_id')
            ->orderBy('max_weight', 'desc')
            ->first();
            
        return $best ? $best->exercise->name : 'Aucun';
    }
}