<?php

namespace Modules\ListingLeads\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingLeads\Models\ListingLead;

class LeadApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $leads = ListingLead::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'email', 'phone', 'status', 'notes', 'created_at']);

        if ($leads->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay leads'], 200);
        }

        return response()->json([
            'data' => $leads,
            'meta' => [
                'total' => $leads->count(),
                'by_status' => $leads->groupBy('status')->map->count(),
            ],
        ]);
    }
}
