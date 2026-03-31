<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::with('user')->paginate(15);
        return view('admin.programs.index', compact('programs'));
    }
    
    public function create()
    {
        $difficultyLevels = ['Débutant', 'Intermédiaire', 'Avancé', 'Expert'];
        return view('admin.programs.create', compact('difficultyLevels'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'difficulty_level' => 'required|string',
            'is_public' => 'boolean',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        $validated['user_id'] = Auth::id();
        
        Program::create($validated);
        
        return redirect()->route('admin.programs.index')
            ->with('success', 'Programme créé avec succès !');
    }
    
    public function edit(Program $program)
    {
        $difficultyLevels = ['Débutant', 'Intermédiaire', 'Avancé', 'Expert'];
        return view('admin.programs.edit', compact('program', 'difficultyLevels'));
    }
    
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'difficulty_level' => 'required|string',
            'is_public' => 'boolean',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        
        $program->update($validated);
        
        return redirect()->route('admin.programs.index')
            ->with('success', 'Programme mis à jour avec succès !');
    }
    
    public function destroy(Program $program)
    {
        $program->delete();
        
        return redirect()->route('admin.programs.index')
            ->with('success', 'Programme supprimé avec succès !');
    }
    
    public function assign(Request $request, Program $program)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        $program->users()->attach($request->user_id, [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active'
        ]);
        
        return redirect()->back()->with('success', 'Programme assigné avec succès !');
    }
    
    public function userPrograms()
    {
        $user = Auth::user();
        $activePrograms = $user->assignedPrograms()
            ->wherePivot('status', 'active')
            ->with('workouts')
            ->get();
            
        $completedPrograms = $user->assignedPrograms()
            ->wherePivot('status', 'completed')
            ->get();
            
        $availablePrograms = Program::where('is_public', true)
            ->whereDoesntHave('users', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
            
        return view('programs.user', compact('activePrograms', 'completedPrograms', 'availablePrograms'));
    }
}