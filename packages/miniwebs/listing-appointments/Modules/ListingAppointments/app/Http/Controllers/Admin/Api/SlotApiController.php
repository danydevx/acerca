<?php

namespace Modules\ListingAppointments\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingAppointments\Models\ListingAppointmentSlot;

class SlotApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $slots = ListingAppointmentSlot::where('listing_id', $business->id)
            ->with(['service:id,name', 'location:id,name'])
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get(['id', 'business_service_id', 'business_location_id', 'day_of_week', 'specific_date', 'start_time', 'end_time', 'is_available', 'slots_available']);

        if ($slots->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay horarios configurados'], 200);
        }

        return response()->json([
            'data' => $slots,
            'meta' => [
                'total' => $slots->count(),
                'by_day_of_week' => $slots->groupBy('day_of_week')->map->count(),
            ],
        ]);
    }
}
