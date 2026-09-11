<?php

namespace Modules\ListingProjects\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingProjects\Models\ListingProject;
use Modules\ListingProjects\Models\ListingProjectCategory;
use Modules\ListingProjects\Policies\ListingProjectPolicy;
use Modules\ListingProjects\Policies\ListingProjectCategoryPolicy;

class ListingProjectsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingProjects';
    protected string $nameLower = 'listingprojects';

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
        Gate::policy(ListingProject::class, ListingProjectPolicy::class);
        Gate::policy(ListingProjectCategory::class, ListingProjectCategoryPolicy::class);
    }
}
