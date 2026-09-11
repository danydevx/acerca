<?php

namespace Modules\ListingAiChatbot\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'ListingAiChatbot';

    public function boot(): void
    {
        $this->map();
        parent::boot();
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
        Route::middleware('web')->group(module_path($this->name, '/routes/member.php'));
    }

    protected function mapPublicRoutes(): void
    {
        Route::middleware('web')->group(module_path($this->name, '/routes/public.php'));
    }

    protected function mapWidgetRoutes(): void
    {
        Route::middleware('api')->group(module_path($this->name, '/routes/widget.php'));
    }

    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web'])
            ->prefix('admin')
            ->group(module_path($this->name, '/routes/admin.php'));
    }
}
