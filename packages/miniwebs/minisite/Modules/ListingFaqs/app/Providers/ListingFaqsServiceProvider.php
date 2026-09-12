<?php

namespace Modules\ListingFaqs\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingFaqs\Models\ListingFaq;
use Modules\ListingFaqs\Models\ListingFaqCategory;
use Modules\ListingFaqs\Policies\ListingFaqPolicy;
use Modules\ListingFaqs\Policies\ListingFaqCategoryPolicy;

class ListingFaqsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingFaqs';
    protected string $nameLower = 'listingfaqs';

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
        Gate::policy(ListingFaq::class, ListingFaqPolicy::class);
        Gate::policy(ListingFaqCategory::class, ListingFaqCategoryPolicy::class);
    }
}
