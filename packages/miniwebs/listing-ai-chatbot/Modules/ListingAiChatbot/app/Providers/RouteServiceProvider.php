<?php

namespace Modules\ListingAiChatbot\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();
        $this->map();
    }

    public function map(): void
    {
        $this->mapMemberRoutes();
        $this->mapPublicRoutes();
        $this->mapWidgetRoutes();
        $this->mapAdminRoutes();
    }

    protected function mapMemberRoutes(): void
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../../routes/member.php');
    }

    protected function mapPublicRoutes(): void
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../../routes/public.php');
    }

    protected function mapWidgetRoutes(): void
    {
        Route::middleware('api')
            ->group(__DIR__ . '/../../routes/widget.php');
    }

    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web'])
            ->prefix('admin')
            ->group(__DIR__ . '/../../routes/admin.php');
    }
}
