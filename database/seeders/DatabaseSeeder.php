<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DefaultRolesSeeder::class,      // Créer les rôles et permissions
            InternalAdminSeeder::class,     // Créer l'admin interne
        ]);
        
        $this->command->info('🎉 Base de données initialisée avec succès !');
        $this->command->info('📧 Admin: admin@fittrack.com');
        $this->command->info('🔑 Mot de passe: admin123');
    }
}