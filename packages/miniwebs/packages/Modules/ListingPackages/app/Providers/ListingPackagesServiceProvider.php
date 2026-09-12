<?php

namespace Modules\ListingPackages\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingPackages\Models\ListingPackage;
use Modules\ListingPackages\Policies\ListingPackagePolicy;

class ListingPackagesServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingPackages';
    protected string $nameLower = 'listingpackages';

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
        Gate::policy(ListingPackage::class, ListingPackagePolicy::class);
    }
}
