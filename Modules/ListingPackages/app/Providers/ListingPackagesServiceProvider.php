<?php

namespace Modules\ListingPackages\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingPackages\Models\ListingPackage;
use Modules\ListingPackages\Policies\ListingPackagePolicy;

class ListingPackagesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingPackage::class, ListingPackagePolicy::class);
    }
}
