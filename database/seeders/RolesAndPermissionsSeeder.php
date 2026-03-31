<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Réinitialiser le cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les rôles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $coachRole = Role::firstOrCreate(['name' => 'coach']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assigner les rôles aux utilisateurs existants
        $users = User::all();
        foreach ($users as $user) {
            if ($user->role === 'admin') {
                $user->assignRole('admin');
                echo "Admin role assigned to: {$user->email}\n";
            } elseif ($user->role === 'coach') {
                $user->assignRole('coach');
                echo "Coach role assigned to: {$user->email}\n";
            } else {
                $user->assignRole('user');
                echo "User role assigned to: {$user->email}\n";
            }
        }

        echo "Roles assigned successfully!\n";
    }
}