<?php

namespace Modules\ListingServices\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ListingServices\Models\ListingService;
use Modules\ListingServices\Models\ListingServiceCategory;

class ServiceController extends Controller
{
    public function index(Request $request, Listing $business)
    {
        $services = $business->services()
            ->with('location')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return Inertia::render('Admin/BusinessContent/ServicesIndex', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
            ],
            'services' => $services,
        ]);
    }

    public function create(Request $request, Listing $business)
    {
        $locations = $business->locations()->where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $categories = ListingServiceCategory::where('listing_id', $business->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/BusinessContent/ServicesCreate', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
            ],
            'locations' => $locations,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request, Listing $business, ActivityService $activity)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg', 'max:2048'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'deposit_required' => ['boolean'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0'],
            'allows_online_booking' => ['boolean'],
            'whatsapp_contact' => ['nullable', 'string', 'max:50'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'business_location_id' => ['nullable', 'exists:listing_locations,id'],
            'category_id' => ['nullable', 'exists:listing_service_categories,id'],
        ]);

        $data['listing_id'] = $business->id;
        if (empty($data['slug'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        if (isset($data['business_location_id']) && $data['business_location_id'] === '') {
            $data['business_location_id'] = null;
        }
        if (isset($data['category_id']) && $data['category_id'] === '') {
            $data['category_id'] = null;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $data['image'] = $path;
        } else {
            unset($data['image']);
        }

        $service = $business->services()->create($data);

        $activity->log('admin_service_created', [
            'actor' => $request->user(),
            'subject' => $service,
            'description' => 'Admin: Servicio creado',
            'request' => $request,
        ]);

        return redirect()->route('admin.business.services.index', $business->id)
            ->with('success', 'Servicio creado correctamente.');
    }

    public function edit(Request $request, Listing $business, ListingService $service)
    {
        $locations = $business->locations()->where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $categories = ListingServiceCategory::where('listing_id', $business->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
        $serviceImages = $service->images()->orderBy('sort_order')->get(['id', 'path', 'filename', 'is_primary']);

        return Inertia::render('Admin/BusinessContent/ServicesEdit', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
            ],
            'service' => [
                'id' => $service->id,
                'name' => $service->name,
                'slug' => $service->slug,
                'description' => $service->description,
                'image' => $this->sanitizeServiceImage($service->image),
                'duration_minutes' => $service->duration_minutes,
                'price' => $service->price,
                'deposit_required' => $service->deposit_required,
                'deposit_amount' => $service->deposit_amount,
                'allows_online_booking' => $service->allows_online_booking,
                'whatsapp_contact' => $service->whatsapp_contact,
                'is_active' => $service->is_active,
                'sort_order' => $service->sort_order,
                'business_location_id' => $service->business_location_id,
                'category_id' => $service->category_id,
            ],
            'locations' => $locations,
            'categories' => $categories,
            'serviceImages' => $serviceImages->map(fn($img) => [
                'id' => $img->id,
                'url' => $img->path ? "/storage/{$img->path}" : null,
                'filename' => $img->filename,
                'is_primary' => $img->is_primary,
            ]),
        ]);
    }

    public function update(Request $request, Listing $business, ListingService $service, ActivityService $activity)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg', 'max:2048'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'deposit_required' => ['boolean'],
            'deposit_amount' => ['nullable', 'numeric', 'min:0'],
            'allows_online_booking' => ['boolean'],
            'whatsapp_contact' => ['nullable', 'string', 'max:50'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'business_location_id' => ['nullable', 'exists:listing_locations,id'],
            'category_id' => ['nullable', 'exists:listing_service_categories,id'],
        ]);

        if (isset($data['business_location_id']) && $data['business_location_id'] === '') {
            $data['business_location_id'] = null;
        }
        if (isset($data['category_id']) && $data['category_id'] === '') {
            $data['category_id'] = null;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $data['image'] = $path;
        } elseif ($request->input('_remove_image')) {
            $data['image'] = null;
        } else {
            unset($data['image']);
        }

        $service->update($data);

        $activity->log('admin_service_updated', [
            'actor' => $request->user(),
            'subject' => $service,
            'description' => 'Admin: Servicio actualizado',
            'request' => $request,
        ]);

        return redirect()->route('admin.business.services.index', $business->id)
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Request $request, Listing $business, ListingService $service, ActivityService $activity)
    {
        $activity->log('admin_service_deleted', [
            'actor' => $request->user(),
            'subject' => $service,
            'description' => 'Admin: Servicio eliminado',
        ]);

        $service->delete();

        return redirect()->route('admin.business.services.index', $business->id)
            ->with('success', 'Servicio eliminado correctamente.');
    }

    private function sanitizeServiceImage(?string $image): ?string
    {
        if ($image === null) {
            return null;
        }
        if (str_starts_with($image, 'data:')) {
            return null;
        }
        return $image;
    }
}
