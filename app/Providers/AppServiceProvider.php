<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Please Confirm Your Email Address')
                ->greeting('Hello ' . $notifiable->name . ',')
                ->line('Thank you for registering. Please click the button below to verify your email address.')
                ->action('Confirm Email', $url)
                ->line('If you did not create an account, no further action is required.')
                ->salutation('Regards, E-COM');
        });


        // ResetPassword::createUrlUsing(function (User $user, string $token) {
        //     return 'http://localhost:8000/reset-password/' . $token . '?email=' . $user->email;
        // });
    }
}
