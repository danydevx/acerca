<?php

namespace Modules\ListingTeamMembers\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingTeamMembers\Models\TeamMemberPosition;

class TeamMemberPositionApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $positions = TeamMemberPosition::where('listing_id', $business->id)
            ->orderBy('sort_order')
            ->get();

        if ($positions->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay puestos'], 200);
        }

        return response()->json([
            'data' => $positions,
            'meta' => ['total' => $positions->count()],
        ]);
    }
}
