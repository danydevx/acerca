<?php

namespace Modules\ListingOfficeHours\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingOfficeHours\Models\ListingSchedule;

class OfficeHoursApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $schedules = ListingSchedule::where('listing_id', $business->id)
            ->with(['location:id,name'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($schedules->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay horarios'], 200);
        }

        return response()->json([
            'data' => $schedules,
            'meta' => ['total' => $schedules->count()],
        ]);
    }
}
