<?php

namespace Modules\ListingFeatures\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingFeatures\Models\Feature;
use Modules\ListingFeatures\Models\FeatureCategory;
use Modules\ListingFeatures\Policies\FeaturePolicy;
use Modules\ListingFeatures\Policies\FeatureCategoryPolicy;

class FeaturesServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingFeatures';
    protected string $nameLower = 'listingfeatures';

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
        Gate::policy(Feature::class, FeaturePolicy::class);
        Gate::policy(FeatureCategory::class, FeatureCategoryPolicy::class);
    }
}
