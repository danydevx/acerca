<?php

namespace Modules\ListingClients\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingClients\Models\ListingClient;
use Modules\ListingClients\Policies\ListingClientPolicy;

class ListingClientsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingClients';
    protected string $nameLower = 'listingclients';

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
        Gate::policy(ListingClient::class, ListingClientPolicy::class);
    }
}
