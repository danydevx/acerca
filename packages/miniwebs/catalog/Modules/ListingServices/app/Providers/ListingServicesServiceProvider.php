<?php

namespace Modules\ListingServices\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingServices\Models\ListingService;
use Modules\ListingServices\Policies\ListingServicePolicy;

class ListingServicesServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingServices';
    protected string $nameLower = 'listingservices';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingService::class, ListingServicePolicy::class);
    }
}
