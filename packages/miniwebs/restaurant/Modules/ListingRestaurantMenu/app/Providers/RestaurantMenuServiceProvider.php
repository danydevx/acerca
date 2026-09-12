<?php

namespace Modules\ListingRestaurantMenu\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\ListingRestaurantMenu\Services\RestaurantMinisiteProvider;

class RestaurantMenuServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mapAdminApiRoutes();

        $this->app->booting(function () {
            if ($this->app->bound(\Modules\ListingMinisite\Services\MinisiteExtensionRegistry::class)) {
                $registry = $this->app->make(\Modules\ListingMinisite\Services\MinisiteExtensionRegistry::class);
                $registry->register(new RestaurantMinisiteProvider());
            }
        });
    }

    protected function mapAdminApiRoutes(): void
    {
        Route::middleware(['auth:api', 'role:superadmin|admin'])
            ->prefix('api/v1/admin')
            ->name('api.v1.admin.')
            ->group(module_path('ListingRestaurantMenu', '/routes/admin_api.php'));
    }
}
