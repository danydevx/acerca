<?php

namespace Modules\ListingPackages\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingPackages\Models\ListingPackage;

class PackageApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $packages = ListingPackage::where('listing_id', $business->id)
            ->orderBy('sort_order')
            ->get();

        if ($packages->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay paquetes'], 200);
        }

        return response()->json([
            'data' => $packages,
            'meta' => ['total' => $packages->count()],
        ]);
    }
}
