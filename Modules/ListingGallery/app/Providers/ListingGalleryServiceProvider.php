<?php

namespace Modules\ListingGallery\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingGallery\Models\ListingGallery;
use Modules\ListingGallery\Models\ListingGalleryImage;
use Modules\ListingGallery\Policies\ListingGalleryImagePolicy;
use Modules\ListingGallery\Policies\ListingGalleryPolicy;

class ListingGalleryServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingGallery';
    protected string $nameLower = 'listinggallery';

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
        Gate::policy(ListingGalleryImage::class, ListingGalleryImagePolicy::class);
        Gate::policy(ListingGallery::class, ListingGalleryPolicy::class);
    }
}
