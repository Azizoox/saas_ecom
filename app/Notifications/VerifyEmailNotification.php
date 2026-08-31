<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    protected string $verificationUrl;

    public function __construct(string $verificationUrl)
    {
        $this->verificationUrl = $verificationUrl;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Vérifiez votre adresse email')
            ->greeting('Bonjour ' . $notifiable->first_name . ' !')
            ->line('Merci de vous être inscrit sur Shopino.')
            ->line('Veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse email.')
            ->action('Vérifier mon email', $this->verificationUrl)
            ->line('Ce lien expire dans 60 minutes.')
            ->line('Si vous n\'avez pas créé de compte, ignorez cet email.')
            ->salutation('Cordialement, L\'équipe Shopino');
    }
}