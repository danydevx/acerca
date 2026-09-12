<?php

namespace Modules\ListingSeo\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'ListingSeo';

    public function register(): void
    {
        parent::register();
    }

    public function boot(): void
    {
        parent::boot();
    }

    public function map(): void
    {
        $this->mapMemberRoutes();
        $this->mapAdminApiRoutes();
    }

    protected function mapMemberRoutes(): void
    {
        Route::middleware(['web'])
            ->group(module_path($this->name, '/routes/member.php'));
    }

    protected function mapAdminApiRoutes(): void
    {
        Route::middleware(['auth:api', 'role:superadmin|admin'])
            ->prefix('api/v1/admin')
            ->name('api.v1.admin.')
            ->group(module_path($this->name, '/routes/admin_api.php'));
    }
}
