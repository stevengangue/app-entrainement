<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionAssignment extends Model
{
    protected $fillable = [
        'training_session_id',
        'user_id',
        'status',
        'completed_at',
        'notes'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    // Relation avec la session d'entraînement
    public function trainingSession()
    {
        return $this->belongsTo(TrainingSession::class);
    }

    // Relation avec l'utilisateur (athlète)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}