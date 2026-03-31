<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AchievementUnlocked extends Notification
{
    use Queueable;
    
    protected $achievement;
    
    public function __construct($achievement)
    {
        $this->achievement = $achievement;
    }
    
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouveau succès débloqué ! 🏆')
            ->greeting('Félicitations ' . $notifiable->name . ' !')
            ->line('Vous venez de débloquer le succès :')
            ->line('**' . $this->achievement['name'] . '**')
            ->line($this->achievement['description'])
            ->action('Voir mes succès', url('/achievements'))
            ->line('Continuez comme ça ! 🎉');
    }
    
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Succès débloqué ! 🏆',
            'message' => $this->achievement['name'] . ' - ' . $this->achievement['description'],
            'achievement' => $this->achievement,
            'type' => 'achievement'
        ];
    }
}