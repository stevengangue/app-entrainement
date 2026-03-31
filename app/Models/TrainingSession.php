<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    protected $fillable = [
        'title',
        'description',
        'coach_id',
        'exercise_id',
        'sets',
        'reps',
        'duration_minutes',
        'scheduled_at',
        'status'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    // Relation avec le coach (celui qui crée la session)
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    // Relation avec l'exercice
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    // Relation avec les athlètes assignés à cette session
    public function athletes()
    {
        return $this->belongsToMany(User::class, 'session_assignments', 'training_session_id', 'user_id')
                    ->withPivot('status', 'completed_at', 'notes')
                    ->withTimestamps();
    }

    // Relation avec les logs d'exercices
    public function exerciseLogs()
    {
        return $this->hasMany(ExerciseLog::class);
    }

    // Vérifier si la session est terminée
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    // Vérifier si la session est à venir
    public function isUpcoming()
    {
        return $this->scheduled_at > now() && $this->status === 'pending';
    }
}