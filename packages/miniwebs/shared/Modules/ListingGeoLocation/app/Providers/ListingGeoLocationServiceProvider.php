<?php

namespace Modules\ListingGeoLocation\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\ListingGeoLocation\Services\GeoLocationService;

class ListingGeoLocationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GeoLocationService::class, function () {
            return new GeoLocationService();
        });
    }

    public function boot(): void
    {
    }
}
