<?php

namespace App\Providers;

use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Remplacer la notification par défaut
        VerifyEmail::toMailUsing(function ($notifiable) {
            return (new CustomVerifyEmail)->toMail($notifiable);
        });
    }
}