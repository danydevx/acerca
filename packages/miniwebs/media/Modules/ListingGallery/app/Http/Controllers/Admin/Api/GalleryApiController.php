<?php

namespace Modules\ListingGallery\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingGallery\Models\ListingGalleryImage;

class GalleryApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $images = ListingGalleryImage::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'title', 'description', 'image_path', 'is_active', 'created_at']);

        if ($images->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay imagenes en la galeria'], 200);
        }

        return response()->json([
            'data' => $images,
            'meta' => ['total' => $images->count()],
        ]);
    }
}
