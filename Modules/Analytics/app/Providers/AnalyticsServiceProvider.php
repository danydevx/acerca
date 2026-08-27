<?php

namespace Modules\Analytics\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\Analytics\Services\AnalyticsCookieService;
use Modules\Analytics\Services\AnalyticsDeviceService;
use Modules\Analytics\Services\AnalyticsQueryService;
use Modules\Analytics\Services\AnalyticsTrackingService;

class AnalyticsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AnalyticsCookieService::class, function ($app) {
            return new AnalyticsCookieService();
        });

        $this->app->singleton(AnalyticsDeviceService::class, function ($app) {
            return new AnalyticsDeviceService();
        });

        $this->app->singleton(AnalyticsTrackingService::class, function ($app) {
            return new AnalyticsTrackingService(
                $app->make(AnalyticsCookieService::class),
                $app->make(AnalyticsDeviceService::class)
            );
        });

        $this->app->singleton(AnalyticsQueryService::class, function ($app) {
            return new AnalyticsQueryService();
        });
    }

    public function boot(): void
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../../routes/public.php');

        Route::middleware(['web', 'auth', 'verified', 'active', 'role:member'])
            ->prefix('member/listings/{listing}/analytics')
            ->name('member.listings.analytics.')
            ->group(__DIR__ . '/../../routes/member.php');
    }
}
