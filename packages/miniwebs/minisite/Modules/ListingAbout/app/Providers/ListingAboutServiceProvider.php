<?php

namespace Modules\ListingAbout\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingAbout\Models\ListingAbout;
use Modules\ListingAbout\Policies\ListingAboutPolicy;

class ListingAboutServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingAbout';
    protected string $nameLower = 'listingabout';

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
        Gate::policy(ListingAbout::class, ListingAboutPolicy::class);
    }
}
