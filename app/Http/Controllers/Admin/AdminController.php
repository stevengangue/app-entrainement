<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
use App\Models\Performance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_coaches' => User::role('coach')->count(),
            'total_athletes' => User::role('user')->count(),
            'total_programs' => Program::count(),
            'total_performances' => Performance::count(),
        ];
        
        $recentUsers = User::orderBy('created_at', 'desc')->limit(10)->get();
        
        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
    
    public function users()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }
    
    public function coaches()
    {
        $coaches = User::role('coach')->with('athletes')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.coaches', compact('coaches'));
    }
    
    public function athletes()
    {
        $athletes = User::role('user')->with('coach')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.athletes', compact('athletes'));
    }
    
    public function createUser()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }
    
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'assigned_coach_id' => 'nullable|exists:users,id'
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'assigned_coach_id' => $validated['assigned_coach_id'] ?? null,
        ]);
        
        $user->assignRole($validated['role']);
        
        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès');
    }
    
    public function editUser(User $user)
    {
        $roles = Role::all();
        $coaches = User::role('coach')->get();
        return view('admin.users.edit', compact('user', 'roles', 'coaches'));
    }
    
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'assigned_coach_id' => 'nullable|exists:users,id'
        ]);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'assigned_coach_id' => $validated['assigned_coach_id'],
        ]);
        
        $user->syncRoles([$validated['role']]);
        
        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour');
    }
    
    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé');
    }
    
    public function assignCoach(Request $request, User $athlete)
    {
        $request->validate([
            'coach_id' => 'required|exists:users,id'
        ]);
        
        $athlete->assigned_coach_id = $request->coach_id;
        $athlete->save();
        
        return back()->with('success', 'Coach assigné avec succès');
    }
}