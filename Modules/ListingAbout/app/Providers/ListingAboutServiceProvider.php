<?php

namespace Modules\ListingAbout\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingAbout\Models\ListingAbout;
use Modules\ListingAbout\Policies\ListingAboutPolicy;

class ListingAboutServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
    }

    public function register(): void
    {
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingAbout::class, ListingAboutPolicy::class);
    }
}
