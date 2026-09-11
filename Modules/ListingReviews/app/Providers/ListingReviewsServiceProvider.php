<?php

namespace Modules\ListingReviews\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingReviews\Models\ListingReview;
use Modules\ListingReviews\Policies\ListingReviewPolicy;

class ListingReviewsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingReview::class, ListingReviewPolicy::class);
    }
}
