<?php

namespace Modules\ListingOfficeHours\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'ListingOfficeHours';

    public function boot(): void
    {
        parent::boot();
    }

    public function map(): void
    {
        $this->mapWebRoutes();
        $this->mapAdminApiRoutes();
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->group(dirname(__DIR__, 2) . '/routes/web.php');
    }

    protected function mapAdminApiRoutes(): void
    {
        Route::middleware(['auth:api', 'role:superadmin|admin'])
            ->prefix('api/v1/admin')
            ->name('api.v1.admin.')
            ->group(dirname(__DIR__, 2) . '/routes/admin_api.php');
    }
}