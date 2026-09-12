<?php

namespace Modules\Properties\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\Properties\Models\Property;

class PropertyApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $properties = Property::where('listing_id', $business->id)
            ->with(['propertyType:id,name,key', 'images'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($properties->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay propiedades'], 200);
        }

        return response()->json([
            'data' => $properties,
            'meta' => ['total' => $properties->count()],
        ]);
    }
}
