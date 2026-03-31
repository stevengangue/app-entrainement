<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Workout;
use App\Notifications\WorkoutReminder;
use Carbon\Carbon;

class SendWorkoutReminders extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send workout reminders to users';
    
    public function handle()
    {
        // Trouver les séances dans les prochaines 24h
        $upcomingWorkouts = Workout::whereHas('program.users', function($query) {
            $query->wherePivot('status', 'active');
        })->with('program.users')->get();
        
        foreach ($upcomingWorkouts as $workout) {
            foreach ($workout->program->users as $user) {
                $hoursUntil = Carbon::now()->diffInHours($workout->created_at);
                
                if ($hoursUntil <= 24 && $hoursUntil >= 23) {
                    $user->notify(new WorkoutReminder($workout, 'dans 24 heures'));
                } elseif ($hoursUntil <= 2 && $hoursUntil >= 1) {
                    $user->notify(new WorkoutReminder($workout, 'dans 2 heures'));
                }
            }
        }
        
        $this->info('Reminders sent successfully!');
    }
}