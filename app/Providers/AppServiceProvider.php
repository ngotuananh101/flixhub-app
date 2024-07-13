<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Models\User;

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
        // Custom route to handle password reset
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return route('auth.reset-password', [
                'id' => $user->id,
                'token' => $token,
            ]);
        });

        // Force HTTPS for production
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
