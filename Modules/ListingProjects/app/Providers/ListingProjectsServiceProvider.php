<?php

namespace Modules\ListingProjects\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingProjects\Models\ListingProject;
use Modules\ListingProjects\Models\ListingProjectCategory;
use Modules\ListingProjects\Policies\ListingProjectPolicy;
use Modules\ListingProjects\Policies\ListingProjectCategoryPolicy;

class ListingProjectsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingProject::class, ListingProjectPolicy::class);
        Gate::policy(ListingProjectCategory::class, ListingProjectCategoryPolicy::class);
    }
}
