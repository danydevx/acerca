<?php

namespace Modules\ListingPromotions\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingPromotions\Models\ListingPromotion;
use Modules\ListingPromotions\Policies\ListingPromotionPolicy;

class ListingPromotionsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingPromotion::class, ListingPromotionPolicy::class);
    }
}
