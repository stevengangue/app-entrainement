<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'name', 'description', 'week_number', 'day_number', 'program_id'
    ];

    // Relation avec le programme
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // Relation avec les exercices
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_exercise')
                    ->withPivot('sets', 'reps', 'rest_time_seconds', 'order_number')
                    ->withTimestamps();
    }
}