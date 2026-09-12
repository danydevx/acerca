<?php

namespace Modules\ListingOfficeHours\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingOfficeHours\Models\ListingSchedule;
use Modules\ListingOfficeHours\Policies\ListingSchedulePolicy;

class ListingOfficeHoursServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingOfficeHours';
    protected string $nameLower = 'listingofficehours';

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
        Gate::policy(ListingSchedule::class, ListingSchedulePolicy::class);
    }
}
