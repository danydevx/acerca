<?php

namespace Modules\ListingBranding\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'ListingBranding';

    public function register(): void
    {
        Log::info('ListingBranding RouteServiceProvider::register() called');
        parent::register();
        Log::info('ListingBranding RouteServiceProvider::register() finished');
    }

    public function boot(): void
    {
        Log::info('ListingBranding RouteServiceProvider::boot() called');
        parent::boot();
        Log::info('ListingBranding RouteServiceProvider::boot() finished');
    }

    public function map(): void
    {
        Log::info('ListingBranding RouteServiceProvider::map() called');
        $this->mapMemberRoutes();
    }

    protected function mapMemberRoutes(): void
    {
        Log::info('ListingBranding mapMemberRoutes() called');
        Route::middleware(['web'])
            ->group(dirname(__DIR__, 2) . '/routes/member.php');
    }
}
