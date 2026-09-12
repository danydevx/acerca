<?php

namespace Modules\ListingPromotions\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'ListingPromotions';

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
        $this->mapPublicRoutes();
    }

    protected function mapMemberRoutes(): void
    {
        Route::middleware(['web'])
            ->group(module_path($this->name, '/routes/member.php'));
    }

    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web'])
            ->group(module_path($this->name, '/routes/admin.php'));
    }

    protected function mapPublicRoutes(): void
    {
        Route::middleware(['web'])
            ->group(module_path($this->name, '/routes/public.php'));
    }
}
