<?php

namespace Modules\ListingAppointments\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\ListingAppointments\Enums\AppointmentStatus;
use Modules\ListingAppointments\Models\ListingAppointment;
use Modules\ListingAppointments\Services\AvailabilityService;
use Modules\Listings\Models\Listing;
use Modules\ListingLocations\Models\ListingLocation;
use Modules\ListingServices\Models\ListingService;

class MinisiteBookingController extends Controller
{
    public function __construct(
        protected AvailabilityService $availability
    ) {}

    public function book(string $slug, Request $request)
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        if (! in_array('appointments', $modules)) {
            abort(404);
        }

        $serviceId = $request->input('service');
        $locationId = $request->input('location');
        $date = $request->input('date', now()->toDateString());

        $services = $business->services()
            ->where('is_active', true)
            ->where('allows_online_booking', true)
            ->orderBy('name')
            ->get(['id', 'name', 'duration_minutes', 'price']);

        $locations = $business->locations()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'address_line_1', 'city']);

        $selectedService = $serviceId
            ? $services->firstWhere('id', (int) $serviceId)
            : $services->first();

        $availableSlots = [];
        if ($selectedService) {
            $availableSlots = $this->availability->getAvailableSlotsForDate(
                $business,
                $date,
                $selectedService->duration_minutes
            );
        }

        return inertia('Public/Business/Book', [
            'business' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'phone' => $business->phone,
                'email' => $business->email,
                'logo_path' => $business->logo_path,
                'website' => $business->website,
                'timezone' => $business->timezone,
            ],
            'services' => $services,
            'locations' => $locations,
            'selectedService' => $selectedService,
            'availableSlots' => $availableSlots,
            'selectedDate' => $date,
            'selectedLocation' => $locationId ? $locations->firstWhere('id', (int) $locationId) : null,
            'theme' => $business->minisiteTheme ? [
                'id' => $business->minisiteTheme->id,
                'name' => $business->minisiteTheme->name,
                'slug' => $business->minisiteTheme->slug,
                'css_variables' => $business->minisiteTheme->css_variables,
                'layout_config' => $business->minisiteTheme->layout_config,
                'section_config' => $business->minisiteTheme->section_config,
            ] : null,
            'theme_css_variables' => $business->minisiteTheme?->css_variables ? json_encode($business->minisiteTheme->css_variables) : null,
            'modules' => $modules,
            'branding' => [
                'generated_css' => $business->brandingSetting?->generated_css,
                'page_style' => $business->brandingSetting?->page_style,
                'section_style' => $business->brandingSetting?->section_style,
                'hero_style' => $business->brandingSetting?->hero_style,
                'buttons_uppercase' => $business->brandingSetting?->buttons_uppercase,
                'dark_mode' => $business->brandingSetting?->dark_mode,
            ],
            'socialNetworks' => [],
            'allLocations' => $locations,
        ]);
    }

    public function store(string $slug, Request $request): RedirectResponse
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        if (! in_array('appointments', $modules)) {
            abort(404);
        }

        $data = $request->validate([
            'service_id' => [
                'required',
                Rule::exists('listing_services', 'id')->where('listing_id', $business->id),
            ],
            'location_id' => [
                'required',
                Rule::exists('listing_locations', 'id')->where('listing_id', $business->id),
            ],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'customer_name' => ['required', 'string', 'max:150'],
            'customer_email' => ['required', 'email', 'max:150'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $service = ListingService::where('id', $data['service_id'])
            ->where('listing_id', $business->id)
            ->firstOrFail();
        $location = ListingLocation::where('id', $data['location_id'])
            ->where('listing_id', $business->id)
            ->firstOrFail();

        if (! $service->allows_online_booking) {
            return back()->withErrors(['start_time' => 'Este servicio no permite reservas en línea.']);
        }

        $slotCheck = $this->availability->isSlotAvailable(
            $business,
            $data['appointment_date'],
            $data['start_time'],
            null,
            $service->duration_minutes
        );

        if (! $slotCheck['available']) {
            return back()->withErrors(['start_time' => $slotCheck['reason']]);
        }

        $endTime = date('H:i', strtotime($data['start_time'].' + '.$service->duration_minutes.' minutes'));

        $appointment = ListingAppointment::create([
            'listing_id' => $business->id,
            'business_location_id' => $location->id,
            'business_service_id' => $service->id,
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'] ?? null,
            'appointment_date' => $data['appointment_date'],
            'start_time' => $data['start_time'],
            'end_time' => $endTime,
            'status' => AppointmentStatus::PENDING,
            'notes' => $data['notes'] ?? null,
        ]);

        return redirect()->route('public.business.booking.success', $slug)
            ->with('appointment_id', $appointment->id);
    }

    public function success(string $slug, Request $request)
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        $theme = $business->minisiteTheme;
        $brandingSetting = $business->brandingSetting;
        $socialNetworks = in_array('socialmedia', $modules)
            ? $business->socialNetworks()->where('is_active', true)->orderBy('sort_order')->get(['id', 'platform', 'url', 'username', 'show_on_hero', 'show_on_footer', 'show_on_contact'])
            : [];
        $locations = $business->locations()->where('is_active', true)->orderBy('is_primary', 'desc')->get(['id', 'name', 'address_line_1', 'city']);

        return inertia('Public/Business/BookingSuccess', [
            'business' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'phone' => $business->phone,
                'email' => $business->email,
                'logo_path' => $business->logo_path,
                'website' => $business->website,
            ],
            'theme' => $theme ? [
                'id' => $theme->id,
                'name' => $theme->name,
                'slug' => $theme->slug,
                'css_variables' => $theme->css_variables,
                'layout_config' => $theme->layout_config,
                'section_config' => $theme->section_config,
            ] : null,
            'theme_css_variables' => $theme?->css_variables ? json_encode($theme->css_variables) : null,
            'modules' => $modules,
            'branding' => [
                'generated_css' => $brandingSetting?->generated_css,
                'page_style' => $brandingSetting?->page_style,
                'section_style' => $brandingSetting?->section_style,
                'hero_style' => $brandingSetting?->hero_style,
                'buttons_uppercase' => $brandingSetting?->buttons_uppercase,
                'dark_mode' => $brandingSetting?->dark_mode,
            ],
            'socialNetworks' => $socialNetworks,
            'locations' => $locations,
        ]);
    }
}