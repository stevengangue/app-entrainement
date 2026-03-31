<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('coach.programs.index', compact('programs'));
    }
    
    public function create()
    {
        $difficultyLevels = ['Débutant', 'Intermédiaire', 'Avancé', 'Expert'];
        return view('coach.programs.create', compact('difficultyLevels'));
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
        
        return redirect()->route('coach.programs.index')
            ->with('success', 'Programme créé avec succès !');
    }
    
    public function edit(Program $program)
    {
        if ($program->user_id !== Auth::id()) {
            abort(403);
        }
        
        $difficultyLevels = ['Débutant', 'Intermédiaire', 'Avancé', 'Expert'];
        return view('coach.programs.edit', compact('program', 'difficultyLevels'));
    }
    
    public function update(Request $request, Program $program)
    {
        if ($program->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'difficulty_level' => 'required|string',
            'is_public' => 'boolean',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        $program->update($validated);
        
        return redirect()->route('coach.programs.index')
            ->with('success', 'Programme mis à jour avec succès !');
    }
    
    public function destroy(Program $program)
    {
        if ($program->user_id !== Auth::id()) {
            abort(403);
        }
        
        $program->delete();
        
        return redirect()->route('coach.programs.index')
            ->with('success', 'Programme supprimé avec succès !');
    }
    
    public function assign(Request $request, Program $program)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        $athlete = User::find($request->user_id);
        if (!$athlete->hasRole('user')) {
            return back()->with('error', 'Cet utilisateur n\'est pas un athlète');
        }
        
        $program->users()->syncWithoutDetaching([$request->user_id => [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active'
        ]]);
        
        return back()->with('success', 'Programme assigné avec succès !');
    }
}