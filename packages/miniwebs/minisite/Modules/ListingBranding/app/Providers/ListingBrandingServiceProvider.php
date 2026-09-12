<?php

namespace Modules\ListingBranding\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingBranding\Models\ListingBrandingSetting;
use Modules\ListingBranding\Policies\ListingBrandingSettingPolicy;

class ListingBrandingServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingBranding';
    protected string $nameLower = 'listingbranding';

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
        Gate::policy(ListingBrandingSetting::class, ListingBrandingSettingPolicy::class);
    }
}
