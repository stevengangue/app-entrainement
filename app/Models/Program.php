<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'duration_weeks', 
        'difficulty_level', 'user_id', 'is_public'
    ];

    // Relation avec le créateur du programme (coach)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les séances du programme
    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    // Relation avec les utilisateurs assignés
    public function users()
    {
        return $this->belongsToMany(User::class, 'program_user')
                    ->withPivot('start_date', 'end_date', 'status')
                    ->withTimestamps();
    }
}