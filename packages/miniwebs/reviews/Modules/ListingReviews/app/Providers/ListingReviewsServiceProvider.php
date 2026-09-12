<?php

namespace Modules\ListingReviews\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingReviews\Models\ListingReview;
use Modules\ListingReviews\Policies\ListingReviewPolicy;

class ListingReviewsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingReviews';
    protected string $nameLower = 'listingreviews';

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
        Gate::policy(ListingReview::class, ListingReviewPolicy::class);
    }
}
