<?php

namespace Modules\ListingContactForm\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ListingContactFormServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingContactForm';

    protected string $nameLower = 'listingcontactform';

    protected array $providers = [
        RouteServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();
    }
}
