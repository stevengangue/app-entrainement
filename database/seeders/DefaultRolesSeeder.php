<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DefaultRolesSeeder extends Seeder
{
    public function run()
    {
        // Réinitialiser le cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les permissions
        $permissions = [
            'view exercises',
            'create exercises',
            'edit exercises',
            'delete exercises',
            'view programs',
            'create programs',
            'edit programs',
            'delete programs',
            'assign programs',
            'view performances',
            'create performances',
            'edit performances',
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Créer les rôles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $coachRole = Role::firstOrCreate(['name' => 'coach']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assigner les permissions
        $adminRole->syncPermissions(Permission::all());
        
        $coachRole->syncPermissions([
            'view exercises',
            'create exercises',
            'edit exercises',
            'view programs',
            'create programs',
            'edit programs',
            'delete programs',
            'assign programs',
            'view performances',
            'view users',
        ]);
        
        $userRole->syncPermissions([
            'view exercises',
            'view programs',
            'view performances',
            'create performances',
            'edit performances',
        ]);

        $this->command->info('✅ Rôles et permissions créés avec succès !');
    }
}