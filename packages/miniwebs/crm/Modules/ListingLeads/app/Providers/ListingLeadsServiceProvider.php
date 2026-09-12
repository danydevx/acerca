<?php

namespace Modules\ListingLeads\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingLeads\Models\ListingLead;
use Modules\ListingLeads\Policies\ListingLeadPolicy;

class ListingLeadsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingLeads';
    protected string $nameLower = 'listingleads';

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
        Gate::policy(ListingLead::class, ListingLeadPolicy::class);
    }
}
