<?php

namespace Modules\ListingAppointments\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingAppointments\Models\ListingAppointment;
use Modules\ListingAppointments\Models\ListingAppointmentSlot;
use Modules\ListingAppointments\Models\ListingAvailability;
use Modules\ListingAppointments\Policies\ListingAppointmentPolicy;
use Modules\ListingAppointments\Policies\ListingAppointmentSlotPolicy;
use Modules\ListingAppointments\Policies\ListingAvailabilityPolicy;

class ListingAppointmentsServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingAppointments';
    protected string $nameLower = 'listingappointments';

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
        Gate::policy(ListingAppointment::class, ListingAppointmentPolicy::class);
        Gate::policy(ListingAppointmentSlot::class, ListingAppointmentSlotPolicy::class);
        Gate::policy(ListingAvailability::class, ListingAvailabilityPolicy::class);
    }
}
