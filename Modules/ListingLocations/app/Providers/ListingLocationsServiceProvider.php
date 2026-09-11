<?php

namespace Modules\ListingLocations\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingLocations\Models\ListingLocation;
use Modules\ListingLocations\Policies\ListingLocationPolicy;

class ListingLocationsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingLocations';
    protected string $nameLower = 'listinglocations';

    protected array $providers = [
        EventServiceProvider::class,
        ListingLocationsRouteServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingLocation::class, ListingLocationPolicy::class);
    }
}
