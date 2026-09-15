<?php

namespace Modules\Properties\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'Properties';

    public function boot(): void
    {
        parent::boot();
    }

    public function map(): void
    {
        $this->mapMemberRoutes();
        $this->mapAdminRoutes();
        $this->mapAdminApiRoutes();
        $this->mapApiRoutes();
    }

    protected function mapMemberRoutes(): void
    {
        Route::middleware(['web', 'auth', 'verified', 'active'])
            ->group(dirname(__DIR__, 2) . '/routes/member.php');
    }

    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web', 'auth', 'verified', 'active', 'role:superadmin|admin'])
            ->group(dirname(__DIR__, 2) . '/routes/admin.php');
    }

    protected function mapAdminApiRoutes(): void
    {
        Route::middleware(['auth:api', 'role:superadmin|admin'])
            ->prefix('api/v1/admin')
            ->name('api.v1.admin.')
            ->group(dirname(__DIR__, 2) . '/routes/admin_api.php');
    }

    protected function mapApiRoutes(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(dirname(__DIR__, 2) . '/routes/api.php');
    }
}
