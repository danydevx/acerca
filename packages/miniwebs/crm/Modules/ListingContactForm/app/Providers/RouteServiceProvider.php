<?php

namespace Modules\ListingContactForm\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'ListingContactForm';

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
}
