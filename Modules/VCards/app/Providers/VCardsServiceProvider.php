<?php

namespace Modules\VCards\Providers;

use Illuminate\Support\Facades\Gate;
use Modules\VCards\Models\VCard;
use Modules\VCards\Models\VCardPackage;
use Modules\VCards\Models\VCardSeoSetting;
use Modules\VCards\Models\VCardTeam;
use Modules\VCards\Policies\VCardPackagePolicy;
use Modules\VCards\Policies\VCardPolicy;
use Modules\VCards\Policies\VCardSeoSettingPolicy;
use Modules\VCards\Policies\VCardTeamPolicy;
use Nwidart\Modules\Support\ModuleServiceProvider;

class VCardsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'VCards';
    protected string $nameLower = 'vcards';

    protected array $providers = [
        RouteServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(VCard::class, VCardPolicy::class);
        Gate::policy(VCardTeam::class, VCardTeamPolicy::class);
        Gate::policy(VCardSeoSetting::class, VCardSeoSettingPolicy::class);
        Gate::policy(VCardPackage::class, VCardPackagePolicy::class);
    }
}
