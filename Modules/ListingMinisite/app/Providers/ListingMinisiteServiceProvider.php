<?php

namespace Modules\ListingMinisite\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingMinisite\Models\ListingMinisiteSection;
use Modules\ListingMinisite\Models\ListingMinisiteSetting;
use Modules\ListingMinisite\Policies\ListingMinisitePolicy;

class ListingMinisiteServiceProvider extends ServiceProvider
{
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
