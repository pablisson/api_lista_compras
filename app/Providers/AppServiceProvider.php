<?php

namespace App\Providers;

use App\Services\KeycloakGuard;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use KeycloakGuard\KeycloakGuard as KeycloakKeycloakGuard;

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
        /**
         * isso faz com que o laravel reconheça o driver keycloak
         */
        Auth::extend('keycloak', function ($app, $name, array $config) {
            return new KeycloakGuard(Auth::createUserProvider($config['provider']),  $app->make(Request::class));
        });

    }
}
