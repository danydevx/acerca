<?php

namespace Modules\VCards\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\VCards\Models\VCard;
use Modules\VCards\Models\VCardPackage;
use Modules\VCards\Models\VCardSeoSetting;
use Modules\VCards\Models\VCardTeam;
use Modules\VCards\Policies\VCardPackagePolicy;
use Modules\VCards\Policies\VCardPolicy;
use Modules\VCards\Policies\VCardSeoSettingPolicy;
use Modules\VCards\Policies\VCardTeamPolicy;

class VCardsServiceProvider extends RouteServiceProvider
{
    protected string $name = 'VCards';

    public function boot(): void
    {
        $this->registerPolicies();
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mapRoutes();
    }

    protected function mapRoutes(): void
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../../routes/web.php');

        Route::middleware('web')
            ->group(__DIR__ . '/../../routes/member.php');

        Route::middleware('web')
            ->group(__DIR__ . '/../../routes/public.php');

        Route::middleware(['auth:api', 'role:superadmin|admin'])
            ->prefix('api/v1/admin')
            ->name('api.v1.admin.')
            ->group(__DIR__ . '/../../routes/admin_api.php');
    }

    protected function registerPolicies(): void
    {
        Gate::policy(VCard::class, VCardPolicy::class);
        Gate::policy(VCardTeam::class, VCardTeamPolicy::class);
        Gate::policy(VCardSeoSetting::class, VCardSeoSettingPolicy::class);
        Gate::policy(VCardPackage::class, VCardPackagePolicy::class);
    }
}
