<?php

namespace Modules\ListingRestaurantMenu\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\ListingRestaurantMenu\Services\RestaurantMinisiteProvider;

class RestaurantMenuServiceProvider extends RouteServiceProvider
{
    public function register(): void
    {
        parent::register();

        if ($this->app->bound(\Modules\ListingMinisite\Services\MinisiteExtensionRegistry::class)) {
            $registry = $this->app->make(\Modules\ListingMinisite\Services\MinisiteExtensionRegistry::class);
            $registry->registerSectionProvider(new RestaurantMinisiteProvider());
        }
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mapAdminApiRoutes();
    }

    protected function mapAdminApiRoutes(): void
    {
        Route::middleware(['auth:api', 'role:superadmin|admin'])
            ->prefix('api/v1/admin')
            ->name('api.v1.admin.')
            ->group(__DIR__ . '/../../routes/admin_api.php');
    }
}
