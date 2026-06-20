<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends BaseVerifyEmail
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        
        return (new MailMessage)
            ->subject('🔐 Confirmez votre adresse email')
            ->view('emails.custom-verify-email', [
                'user' => $notifiable,
                'url' => $verificationUrl,
                'appName' => config('app.name'),
                'expireMinutes' => config('auth.verification.expire', 60)
            ]);
    }
}