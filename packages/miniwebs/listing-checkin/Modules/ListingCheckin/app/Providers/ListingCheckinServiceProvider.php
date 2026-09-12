<?php

namespace Modules\ListingCheckin\Providers;

use Illuminate\Support\ServiceProvider;

class ListingCheckinServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
