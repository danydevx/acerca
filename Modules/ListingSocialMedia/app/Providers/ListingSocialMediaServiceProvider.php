<?php

namespace Modules\ListingSocialMedia\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingSocialMedia\Models\ListingSocialNetwork;
use Modules\ListingSocialMedia\Policies\ListingSocialNetworkPolicy;

class ListingSocialMediaServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingSocialNetwork::class, ListingSocialNetworkPolicy::class);
    }
}
