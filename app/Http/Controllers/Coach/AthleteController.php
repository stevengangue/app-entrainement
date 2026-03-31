<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AthleteController extends Controller
{
    public function index()
    {
        $athletes = Auth::user()->athletes()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('coach.athletes.index', compact('athletes'));
    }
    
    public function show(User $user)
    {
        if ($user->assigned_coach_id !== Auth::id()) {
            abort(403);
        }
        
        $programs = $user->assignedPrograms()
            ->withPivot('start_date', 'end_date', 'status')
            ->get();
            
        $performances = $user->performances()
            ->with('exercise')
            ->orderBy('date', 'desc')
            ->limit(20)
            ->get();
            
        $availablePrograms = Program::where('user_id', Auth::id())
            ->whereDoesntHave('users', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();
            
        return view('coach.athletes.show', compact('user', 'programs', 'performances', 'availablePrograms'));
    }
    
    public function assignProgram(Request $request, User $user)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        $program = Program::find($request->program_id);
        
        if ($program->user_id !== Auth::id()) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à assigner ce programme');
        }
        
        $user->assignedPrograms()->syncWithoutDetaching([$request->program_id => [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active'
        ]]);
        
        return back()->with('success', 'Programme assigné avec succès à ' . $user->name);
    }
}