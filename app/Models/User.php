<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'bio',
        'avatar',
        'is_active',
        'assigned_coach_id',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relation avec les programmes assignés (table pivot)
    public function assignedPrograms()
    {
        return $this->belongsToMany(Program::class, 'program_user')
                    ->withPivot('start_date', 'end_date', 'status')
                    ->withTimestamps();
    }

    // Relation avec les programmes créés (pour les coachs)
    public function programs()
    {
        return $this->hasMany(Program::class, 'user_id');
    }

    // Relation avec les performances
    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

    // Relation avec le coach (pour les athlètes)
    public function coach()
    {
        return $this->belongsTo(User::class, 'assigned_coach_id');
    }

    // Relation avec les athlètes (pour les coachs)
    public function athletes()
    {
        return $this->hasMany(User::class, 'assigned_coach_id');
    }

    // Vérifier si l'utilisateur est un coach
    public function isCoach()
    {
        return $this->role === 'coach' || $this->hasRole('coach');
    }

    // Vérifier si l'utilisateur est un athlète
    public function isAthlete()
    {
        return $this->role === 'user' || $this->hasRole('user');
    }

    // Vérifier si l'utilisateur est admin
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}