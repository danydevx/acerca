<?php

namespace Modules\ListingProducts\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingProducts\Models\ListingProduct;
use Modules\ListingProducts\Models\ListingProductCategory;
use Modules\ListingProducts\Policies\ListingProductPolicy;
use Modules\ListingProducts\Policies\ListingProductCategoryPolicy;

class ListingProductsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingProducts';
    protected string $nameLower = 'listingproducts';

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
        Gate::policy(ListingProduct::class, ListingProductPolicy::class);
        Gate::policy(ListingProductCategory::class, ListingProductCategoryPolicy::class);
    }
}
