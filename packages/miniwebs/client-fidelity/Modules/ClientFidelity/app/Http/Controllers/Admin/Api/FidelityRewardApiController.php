<?php

namespace Modules\ClientFidelity\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ClientFidelity\Models\FidelityReward;

class FidelityRewardApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $rewards = FidelityReward::where('listing_id', $business->id)
            ->orderBy('sort_order')
            ->get();

        if ($rewards->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay recompensas'], 200);
        }

        return response()->json([
            'data' => $rewards,
            'meta' => ['total' => $rewards->count()],
        ]);
    }
}
