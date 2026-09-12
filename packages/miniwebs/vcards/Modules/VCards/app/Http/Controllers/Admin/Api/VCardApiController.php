<?php

namespace Modules\VCards\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\VCards\Models\VCard;

class VCardApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $vcards = VCard::where('listing_id', $business->id)
            ->with(['team:id,name'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($vcards->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay vCards'], 200);
        }

        return response()->json([
            'data' => $vcards,
            'meta' => ['total' => $vcards->count()],
        ]);
    }
}
