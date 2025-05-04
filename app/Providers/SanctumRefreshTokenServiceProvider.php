<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class SanctumRefreshTokenServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Sanctum::ignoreMigrations();
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        Sanctum::authenticateAccessTokensUsing(function ($token, $isValid) {
            if ($token->expired_at)
                $isValid = $isValid && $token->expired_at->gte(now());

            return $isValid && ($this->isRefreshRoute() ?
                    $this->isRefreshTokenValid($token) :
                    $this->isAuthTokenValid($token));
        });
    }

    private function isAuthTokenValid($token): bool
    {
        return $token->can('auth') && $token->cant('refresh');
    }

    private function isRefreshTokenValid($token): bool
    {
        return $token->can('refresh') && $token->cant('auth');
    }

    /**
     * @return bool
     */
    public function isRefreshRoute(): bool
    {
        return
            Route::currentRouteName() == config('sanctum.refresh_route_name') ||
            Route::currentRouteName() == config('sanctum.logout_route_name');
    }
}
