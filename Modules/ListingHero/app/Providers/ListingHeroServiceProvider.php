<?php

namespace Modules\ListingHero\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingHero\Models\ListingHero;
use Modules\ListingHero\Policies\ListingHeroPolicy;

class ListingHeroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingHero::class, ListingHeroPolicy::class);
    }
}
