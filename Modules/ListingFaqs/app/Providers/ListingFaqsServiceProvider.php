<?php

namespace Modules\ListingFaqs\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingFaqs\Models\ListingFaq;
use Modules\ListingFaqs\Models\ListingFaqCategory;
use Modules\ListingFaqs\Policies\ListingFaqPolicy;
use Modules\ListingFaqs\Policies\ListingFaqCategoryPolicy;

class ListingFaqsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingFaq::class, ListingFaqPolicy::class);
        Gate::policy(ListingFaqCategory::class, ListingFaqCategoryPolicy::class);
    }
}
