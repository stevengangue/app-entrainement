<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    protected $signature = 'make:admin {email?} {password?}';
    protected $description = 'Créer un administrateur interne';

    public function handle()
    {
        $email = $this->argument('email') ?? $this->ask('Email de l\'administrateur', 'admin@fittrack.com');
        $password = $this->argument('password') ?? $this->secret('Mot de passe de l\'administrateur');

        if (!$password) {
            $password = 'admin123';
            $this->info('Mot de passe par défaut: admin123');
        }

        // Vérifier si l'admin existe déjà
        if (User::where('email', $email)->exists()) {
            $this->error('Un utilisateur avec cet email existe déjà !');
            return 1;
        }

        // Créer l'admin
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Assigner le rôle admin
        $admin->assignRole('admin');

        $this->info('✅ Administrateur créé avec succès !');
        $this->table(
            ['Email', 'Mot de passe'],
            [[$email, $password]]
        );

        return 0;
    }
}