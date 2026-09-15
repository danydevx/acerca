<?php

namespace Modules\ListingProducts\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'ListingProducts';

    public function boot(): void
    {
        parent::boot();
    }

    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapMemberRoutes();
        $this->mapAdminRoutes();
        $this->mapAdminApiRoutes();
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->group(dirname(__DIR__, 2) . '/routes/web.php');
    }

    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('api')->name('api.')->group(dirname(__DIR__, 2) . '/routes/api.php');
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
