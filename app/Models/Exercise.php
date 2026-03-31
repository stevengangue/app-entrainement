<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'instructions', 
        'muscle_group', 'difficulty_level', 'image_url', 
        'video_url', 'category_id'
    ];

    // Relation avec la catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation avec les workouts
    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'workout_exercise')
                    ->withPivot('sets', 'reps', 'rest_time_seconds', 'order_number')
                    ->withTimestamps();
    }

    // Relation avec les performances
    public function performances()
    {
        return $this->hasMany(Performance::class);
    }
}