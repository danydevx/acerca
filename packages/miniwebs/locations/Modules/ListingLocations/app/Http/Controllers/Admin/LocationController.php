<?php

namespace Modules\ListingLocations\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ListingLocations\Models\ListingLocation;

class LocationController extends Controller
{
    public function index(Request $request, Listing $business)
    {
        $locations = $business->locations()
            ->orderBy('is_primary', 'desc')
            ->orderBy('name')
            ->paginate(20);

        return Inertia::render('Admin/BusinessContent/LocationsIndex', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
            ],
            'locations' => $locations,
        ]);
    }

    public function create(Request $request, Listing $business)
    {
        return Inertia::render('Admin/BusinessContent/LocationsCreate', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
            ],
        ]);
    }

    public function store(Request $request, Listing $business, ActivityService $activity)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'directions_url' => ['nullable', 'string', 'max:500'],
            'is_primary' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        $location = $business->locations()->create($data);

        $activity->log('admin_location_created', [
            'actor' => $request->user(),
            'subject' => $location,
            'description' => 'Admin: Ubicacion creada para negocio '.$business->name,
            'request' => $request,
        ]);

        return redirect()->route('admin.business.locations.index', $business->id)
            ->with('success', 'Ubicacion creada correctamente.');
    }

    public function edit(Request $request, Listing $business, ListingLocation $location)
    {
        return Inertia::render('Admin/BusinessContent/LocationsEdit', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
            ],
            'location' => [
                'id' => $location->id,
                'name' => $location->name,
                'address_line_1' => $location->address_line_1,
                'address_line_2' => $location->address_line_2,
                'city' => $location->city,
                'state' => $location->state,
                'postal_code' => $location->postal_code,
                'country' => $location->country,
                'phone' => $location->phone,
                'email' => $location->email,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'directions_url' => $location->directions_url,
                'is_primary' => $location->is_primary,
                'is_active' => $location->is_active,
            ],
        ]);
    }

    public function update(Request $request, Listing $business, ListingLocation $location, ActivityService $activity)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'directions_url' => ['nullable', 'string', 'max:500'],
            'is_primary' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        $location->update($data);

        $activity->log('admin_location_updated', [
            'actor' => $request->user(),
            'subject' => $location,
            'description' => 'Admin: Ubicacion actualizada',
            'request' => $request,
        ]);

        return redirect()->route('admin.business.locations.index', $business->id)
            ->with('success', 'Ubicacion actualizada correctamente.');
    }

    public function destroy(Request $request, Listing $business, ListingLocation $location, ActivityService $activity)
    {
        $activity->log('admin_location_deleted', [
            'actor' => $request->user(),
            'subject' => $location,
            'description' => 'Admin: Ubicacion eliminada',
        ]);

        $location->delete();

        return redirect()->route('admin.business.locations.index', $business->id)
            ->with('success', 'Ubicacion eliminada correctamente.');
    }
}
