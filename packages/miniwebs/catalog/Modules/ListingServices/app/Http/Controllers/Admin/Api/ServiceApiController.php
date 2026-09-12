<?php

namespace Modules\ListingServices\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingServices\Models\ListingService;

class ServiceApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $services = ListingService::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'description', 'price', 'duration', 'is_active']);

        if ($services->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay servicios configurados'], 200);
        }

        return response()->json([
            'data' => $services,
            'meta' => ['total' => $services->count()],
        ]);
    }
}
