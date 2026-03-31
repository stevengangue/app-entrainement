<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs
     */
    public function index()
    {
        $users = User::with('roles')->paginate(15);
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Afficher les détails d'un utilisateur
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Assigner un rôle à un utilisateur
     */
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);
        
        $user->syncRoles([$request->role]);
        
        return redirect()->back()->with('success', 'Rôle assigné avec succès');
    }
    
    /**
     * Désactiver un utilisateur
     */
    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        return redirect()->back()->with('success', 'Statut utilisateur modifié');
    }
}