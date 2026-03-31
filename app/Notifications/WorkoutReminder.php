<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class WorkoutReminder extends Notification
{
    use Queueable;
    
    protected $workout;
    protected $time;
    
    public function __construct($workout, $time)
    {
        $this->workout = $workout;
        $this->time = $time;
    }
    
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Rappel : Séance d\'entraînement ' . $this->workout->name)
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Vous avez une séance d\'entraînement prévue dans ' . $this->time)
            ->line('**' . $this->workout->name . '**')
            ->action('Voir la séance', url('/workouts/' . $this->workout->id))
            ->line('Préparez-vous à donner le meilleur de vous-même ! 💪');
    }
    
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Séance d\'entraînement',
            'message' => 'Votre séance "' . $this->workout->name . '" commence dans ' . $this->time,
            'workout_id' => $this->workout->id,
            'type' => 'workout_reminder'
        ];
    }
}