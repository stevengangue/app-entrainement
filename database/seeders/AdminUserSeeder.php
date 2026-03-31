<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@entrainement.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('admin');

        $coach = User::create([
            'name' => 'Coach',
            'email' => 'coach@entrainement.com',
            'password' => Hash::make('password123'),
        ]);
        $coach->assignRole('coach');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@entrainement.com',
            'password' => Hash::make('password123'),
        ]);
        $user->assignRole('user');
    }
}