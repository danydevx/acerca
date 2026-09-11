<?php

namespace Modules\ListingPromotions\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingPromotions\Models\ListingPromotion;
use Modules\ListingPromotions\Policies\ListingPromotionPolicy;

class ListingPromotionsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingPromotions';
    protected string $nameLower = 'listingpromotions';

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
        Gate::policy(ListingPromotion::class, ListingPromotionPolicy::class);
    }
}
