<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class InternalAdminSeeder extends Seeder
{
    public function run()
    {
        // Vérifier si l'admin existe déjà
        $adminExists = User::where('email', 'admin@fittrack.com')->exists();
        
        if (!$adminExists) {
            // Créer l'admin interne
            $admin = User::create([
                'name' => 'Administrateur Principal',
                'email' => 'admin@fittrack.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
            
            // Assigner le rôle admin
            $admin->assignRole('admin');
            
            $this->command->info('✅ Admin interne créé avec succès !');
            $this->command->info('   Email: admin@fittrack.com');
            $this->command->info('   Mot de passe: admin123');
        } else {
            $this->command->info('ℹ️ L\'admin interne existe déjà.');
        }
    }
}