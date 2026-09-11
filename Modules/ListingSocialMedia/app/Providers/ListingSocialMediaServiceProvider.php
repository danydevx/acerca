<?php

namespace Modules\ListingSocialMedia\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingSocialMedia\Models\ListingSocialNetwork;
use Modules\ListingSocialMedia\Policies\ListingSocialNetworkPolicy;

class ListingSocialMediaServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingSocialMedia';
    protected string $nameLower = 'listingsocialmedia';

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
        Gate::policy(ListingSocialNetwork::class, ListingSocialNetworkPolicy::class);
    }
}
