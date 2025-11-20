<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AccessManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(AccessManager::class, function ($app) {
            return new AccessManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
