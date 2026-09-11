<?php

namespace Modules\ListingGallery\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Modules\Listings\Models\Listing;
use Modules\ListingGallery\Models\ListingGallery;
use Modules\ListingGallery\Models\ListingGalleryImage;

class GalleryController extends Controller
{
    private const MAX_FILE_SIZE_KB = 5120;
    private const ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

    public function index(Request $request, Listing $business, ?ListingGallery $gallery = null)
    {
        $galleries = $business->galleries()
            ->orderByDesc('is_primary')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->withCount('images')
            ->get(['id', 'name', 'is_primary', 'is_active']);

        if (! $gallery) {
            $gallery = ListingGallery::primaryFor($business->id);
        }

        if (! $gallery || $gallery->listing_id !== $business->id) {
            $gallery = $galleries->firstWhere('is_primary', true) ? ListingGallery::find($galleries->firstWhere('is_primary', true)['id']) : null;
        }

        $images = $gallery
            ? $business->galleryImages()->where('business_gallery_id', $gallery->id)
                ->with('location')
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->paginate(20)
            : collect();

        $locations = $business->locations()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/BusinessContent/GalleryIndex', [
            'listing' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
            ],
            'images' => $images,
            'galleries' => $galleries,
            'currentGalleryId' => $gallery?->id,
            'locations' => $locations,
            'maxSizeKb' => self::MAX_FILE_SIZE_KB,
        ]);
    }

    public function store(Request $request, Listing $business, ActivityService $activity)
    {
        $data = $request->validate([
            'file' => ['required', 'file', 'max:'.self::MAX_FILE_SIZE_KB, 'mimetypes:'.implode(',', self::ALLOWED_MIME_TYPES)],
            'business_gallery_id' => [
                'required',
                Rule::exists('listing_galleries', 'id')->where('listing_id', $business->id),
            ],
            'title' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'business_location_id' => ['nullable', 'exists:listing_locations,id'],
        ], [
            'file.max' => 'El archivo supera el tamaño máximo de 5MB.',
            'file.mimetypes' => 'Solo se permiten imágenes (JPEG, PNG, WebP, GIF).',
        ]);

        $file = $request->file('file');
        $disk = 'public';
        $path = $file->store('gallery/'.$business->id, ['disk' => $disk]);

        $image = $business->galleryImages()->create([
            'listing_id' => $business->id,
            'business_gallery_id' => $data['business_gallery_id'],
            'path' => Storage::disk($disk)->url($path),
            'filename' => basename($path),
            'original_name' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'business_location_id' => $request->input('business_location_id'),
            'is_active' => true,
            'sort_order' => 0,
        ]);

        $activity->log('gallery_image_uploaded', [
            'actor' => $request->user(),
            'subject' => $image,
            'description' => 'Imagen subida a galeria (admin)',
            'request' => $request,
        ]);

        return redirect()->route('admin.business.gallery.index', $business->id)->with('success', 'Imagen subida correctamente.');
    }

    public function update(Request $request, Listing $business, ListingGalleryImage $image, ActivityService $activity)
    {
        $data = $request->validate([
            'business_gallery_id' => [
                'required',
                Rule::exists('listing_galleries', 'id')->where('listing_id', $business->id),
            ],
            'title' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'business_location_id' => ['nullable', 'exists:listing_locations,id'],
        ]);

        $image->update($data);

        $activity->log('gallery_image_updated', [
            'actor' => $request->user(),
            'subject' => $image,
            'description' => 'Imagen de galeria actualizada (admin)',
            'request' => $request,
        ]);

        return redirect()->route('admin.business.gallery.index', $business->id)->with('success', 'Imagen actualizada correctamente.');
    }

    public function destroy(Request $request, Listing $business, ListingGalleryImage $image, ActivityService $activity)
    {
        if ($image->path) {
            $path = str_replace(url('/').'/storage/', '', $image->path);
            Storage::disk('public')->delete($path);
        }

        $activity->log('gallery_image_deleted', [
            'actor' => $request->user(),
            'subject' => $image,
            'description' => 'Imagen de galeria eliminada (admin)',
        ]);

        $image->delete();

        return redirect()->route('admin.business.gallery.index', $business->id)->with('success', 'Imagen eliminada correctamente.');
    }
}
