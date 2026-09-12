<?php

namespace Modules\ListingAppointments\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Listings\Models\Listing;
use Modules\ListingAppointments\Enums\AppointmentStatus;
use Modules\ListingAppointments\Models\ListingAppointment;
use Modules\ListingLocations\Models\ListingLocation;
use Modules\ListingServices\Models\ListingService;

class DirectoryAppointmentController extends Controller
{
    public function store(Request $request, string $slug): RedirectResponse
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

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
            'start_time' => ['required'],
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

        return redirect()->back()->with('success', 'Cita solicitada correctamente. Te contactaremos pronto para confirmar.');
    }
}