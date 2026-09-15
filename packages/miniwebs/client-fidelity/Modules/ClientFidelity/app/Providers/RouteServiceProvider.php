<?php

namespace Modules\ClientFidelity\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(dirname(__DIR__, 2) . '/routes/web.php');

            Route::middleware('api')
                ->prefix('api')
                ->group(dirname(__DIR__, 2) . '/routes/api.php');

            Route::middleware(['auth:api', 'role:superadmin|admin'])
                ->prefix('api/v1/admin')
                ->name('api.v1.admin.')
                ->group(dirname(__DIR__, 2) . '/routes/admin_api.php');
        });
    }
}
