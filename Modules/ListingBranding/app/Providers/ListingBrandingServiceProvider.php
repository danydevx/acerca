<?php

namespace Modules\ListingBranding\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingBranding\Models\ListingBrandingSetting;
use Modules\ListingBranding\Policies\ListingBrandingSettingPolicy;

class ListingBrandingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingBrandingSetting::class, ListingBrandingSettingPolicy::class);
    }
}
