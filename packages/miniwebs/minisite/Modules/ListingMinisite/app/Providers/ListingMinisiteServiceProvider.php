<?php

namespace Modules\ListingMinisite\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingMinisite\Models\ListingMinisiteSection;
use Modules\ListingMinisite\Models\ListingMinisiteSetting;
use Modules\ListingMinisite\Policies\ListingMinisitePolicy;
use Modules\ListingMinisite\Services\MinisiteExtensionRegistry;

class ListingMinisiteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MinisiteExtensionRegistry::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/member.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/public.php');
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingMinisiteSetting::class, ListingMinisitePolicy::class);
        Gate::policy(ListingMinisiteSection::class, ListingMinisitePolicy::class);
    }
}
