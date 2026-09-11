<?php

namespace Modules\ListingLocations\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingLocations\Models\ListingLocation;

class LocationApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $locations = ListingLocation::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'address', 'city', 'state', 'country', 'phone', 'email', 'coordinates', 'is_primary', 'is_active', 'created_at']);

        if ($locations->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay ubicaciones configuradas'], 200);
        }

        return response()->json([
            'data' => $locations,
            'meta' => ['total' => $locations->count()],
        ]);
    }
}
