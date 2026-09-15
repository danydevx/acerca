<?php

namespace Modules\ListingHero\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'ListingHero';

    public function register(): void
    {
        parent::register();
    }

    public function boot(): void
    {
        $this->map();
        parent::boot();
    }

    public function map(): void
    {
        $this->mapMemberRoutes();
        $this->mapAdminRoutes();
        $this->mapAdminApiRoutes();
    }

    protected function mapMemberRoutes(): void
    {
        Route::middleware(['web'])
            ->group(dirname(__DIR__, 2) . '/routes/member.php');
    }

    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web'])
            ->group(dirname(__DIR__, 2) . '/routes/admin.php');
    }

    protected function mapAdminApiRoutes(): void
    {
        Route::middleware(['auth:api', 'role:superadmin|admin'])
            ->prefix('api/v1/admin')
            ->name('api.v1.admin.')
            ->group(dirname(__DIR__, 2) . '/routes/admin_api.php');
    }
}
