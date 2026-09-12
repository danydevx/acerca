<?php

namespace Modules\ListingAppointments\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ListingAppointments\Enums\AppointmentStatus;
use Modules\ListingAppointments\Models\ListingAppointment;
use Modules\ListingServices\Models\ListingService;

class AppointmentController extends Controller
{
    public function index(Request $request, Listing $business)
    {
        $appointments = $business->appointments()
            ->with(['location', 'service'])
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time')
            ->paginate(20);

        return Inertia::render('Admin/BusinessContent/AppointmentsIndex', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
            ],
            'appointments' => $appointments,
        ]);
    }

    public function create(Request $request, Listing $business)
    {
        $services = $business->services()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'duration_minutes', 'price']);

        $locations = $business->locations()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'address_line_1']);

        return Inertia::render('Admin/BusinessContent/AppointmentsCreate', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
            ],
            'services' => $services,
            'locations' => $locations,
        ]);
    }

    public function store(Request $request, Listing $business, ActivityService $activity)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:150'],
            'customer_email' => ['required', 'email', 'max:150'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'business_service_id' => [
                'required',
                Rule::exists('listing_services', 'id')->where('listing_id', $business->id),
            ],
            'business_location_id' => [
                'required',
                Rule::exists('listing_locations', 'id')->where('listing_id', $business->id),
            ],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string'],
        ]);

        $service = ListingService::where('id', $data['business_service_id'])
            ->where('listing_id', $business->id)
            ->firstOrFail();
        $endTime = date('H:i', strtotime($data['start_time'].' + '.$service->duration_minutes.' minutes'));

        $appointment = $business->appointments()->create([
            'listing_id' => $business->id,
            'business_location_id' => $data['business_location_id'],
            'business_service_id' => $data['business_service_id'],
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'] ?? null,
            'appointment_date' => $data['appointment_date'],
            'start_time' => $data['start_time'],
            'end_time' => $endTime,
            'status' => AppointmentStatus::PENDING,
            'notes' => $data['notes'] ?? null,
        ]);

        $activity->log('appointment_created', [
            'actor' => $request->user(),
            'subject' => $appointment,
            'description' => 'Cita creada (admin)',
            'request' => $request,
        ]);

        return redirect()->route('admin.business.appointments.index', $business->id)
            ->with('success', 'Cita creada correctamente.');
    }

    public function show(Request $request, Listing $business, ListingAppointment $appointment)
    {
        $appointment->load(['location', 'service']);

        return Inertia::render('Admin/BusinessContent/AppointmentsShow', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
            ],
            'appointment' => [
                'id' => $appointment->id,
                'customer_name' => $appointment->customer_name,
                'customer_email' => $appointment->customer_email,
                'customer_phone' => $appointment->customer_phone,
                'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                'start_time' => $appointment->start_time,
                'end_time' => $appointment->end_time,
                'status' => $appointment->status->value,
                'status_label' => $appointment->status->label(),
                'notes' => $appointment->notes,
                'location' => $appointment->location ? [
                    'id' => $appointment->location->id,
                    'name' => $appointment->location->name,
                ] : null,
                'service' => $appointment->service ? [
                    'id' => $appointment->service->id,
                    'name' => $appointment->service->name,
                ] : null,
            ],
        ]);
    }

    public function edit(Request $request, Listing $business, ListingAppointment $appointment)
    {
        $appointment->load(['location', 'service']);

        $services = $business->services()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'duration_minutes', 'price']);

        $locations = $business->locations()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'address_line_1']);

        return Inertia::render('Admin/BusinessContent/AppointmentsEdit', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
            ],
            'appointment' => [
                'id' => $appointment->id,
                'customer_name' => $appointment->customer_name,
                'customer_email' => $appointment->customer_email,
                'customer_phone' => $appointment->customer_phone,
                'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                'start_time' => $appointment->start_time,
                'end_time' => $appointment->end_time,
                'status' => $appointment->status->value,
                'notes' => $appointment->notes,
                'business_service_id' => $appointment->business_service_id,
                'business_location_id' => $appointment->business_location_id,
            ],
            'services' => $services,
            'locations' => $locations,
        ]);
    }

    public function update(Request $request, Listing $business, ListingAppointment $appointment, ActivityService $activity)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:150'],
            'customer_email' => ['required', 'email', 'max:150'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'business_service_id' => [
                'required',
                Rule::exists('listing_services', 'id')->where('listing_id', $business->id),
            ],
            'business_location_id' => [
                'required',
                Rule::exists('listing_locations', 'id')->where('listing_id', $business->id),
            ],
            'appointment_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'status' => ['required', 'string', 'in:pending,confirmed,cancelled,completed,no_show'],
            'notes' => ['nullable', 'string'],
        ]);

        $service = ListingService::where('id', $data['business_service_id'])
            ->where('listing_id', $business->id)
            ->firstOrFail();
        $endTime = date('H:i', strtotime($data['start_time'].' + '.$service->duration_minutes.' minutes'));

        $appointment->update([
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'] ?? null,
            'business_service_id' => $data['business_service_id'],
            'business_location_id' => $data['business_location_id'],
            'appointment_date' => $data['appointment_date'],
            'start_time' => $data['start_time'],
            'end_time' => $endTime,
            'status' => AppointmentStatus::from($data['status']),
            'notes' => $data['notes'] ?? null,
            'cancelled_at' => $data['status'] === 'cancelled' ? now() : null,
        ]);

        $activity->log('appointment_updated', [
            'actor' => $request->user(),
            'subject' => $appointment,
            'description' => 'Cita actualizada (admin)',
            'request' => $request,
        ]);

        return redirect()->route('admin.business.appointments.index', $business->id)
            ->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy(Request $request, Listing $business, ListingAppointment $appointment, ActivityService $activity)
    {
        $activity->log('appointment_deleted', [
            'actor' => $request->user(),
            'subject' => $appointment,
            'description' => 'Cita eliminada (admin)',
        ]);

        $appointment->delete();

        return redirect()->route('admin.business.appointments.index', $business->id)
            ->with('success', 'Cita eliminada correctamente.');
    }

    public function cancel(Request $request, Listing $business, ListingAppointment $appointment, ActivityService $activity)
    {
        $appointment->update([
            'status' => AppointmentStatus::CANCELLED,
            'cancelled_at' => now(),
        ]);

        $activity->log('appointment_cancelled', [
            'actor' => $request->user(),
            'subject' => $appointment,
            'description' => 'Cita cancelada (admin)',
            'request' => $request,
        ]);

        return redirect()->back()->with('success', 'Cita cancelada correctamente.');
    }
}
