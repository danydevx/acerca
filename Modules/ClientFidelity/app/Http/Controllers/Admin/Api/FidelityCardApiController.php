<?php

namespace Modules\ClientFidelity\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ClientFidelity\Models\ClientFidelityCard;

class FidelityCardApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $cards = ClientFidelityCard::where('listing_id', $business->id)
            ->with(['reward:id,name,description'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($cards->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay tarjetas'], 200);
        }

        return response()->json([
            'data' => $cards,
            'meta' => ['total' => $cards->count()],
        ]);
    }
}
