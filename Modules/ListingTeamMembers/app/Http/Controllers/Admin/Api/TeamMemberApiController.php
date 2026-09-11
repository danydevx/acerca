<?php

namespace Modules\ListingTeamMembers\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingTeamMembers\Models\ListingTeamMember;

class TeamMemberApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $members = ListingTeamMember::where('listing_id', $business->id)
            ->with(['position:id,name'])
            ->orderBy('sort_order')
            ->get();

        if ($members->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay miembros'], 200);
        }

        return response()->json([
            'data' => $members,
            'meta' => ['total' => $members->count()],
        ]);
    }
}
