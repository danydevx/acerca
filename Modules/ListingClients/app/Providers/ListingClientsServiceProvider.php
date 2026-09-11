<?php

namespace Modules\ListingClients\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingClients\Models\ListingClient;
use Modules\ListingClients\Policies\ListingClientPolicy;

class ListingClientsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingClient::class, ListingClientPolicy::class);
    }
}
