<?php

namespace Modules\ListingAppointments\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Listings\Models\Listing;
use Modules\ListingAppointments\Models\ListingAppointment;

class AppointmentApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $perPage = min((int) request()->get('per_page', 20), 100);

        $appointments = ListingAppointment::where('listing_id', $business->id)
            ->with(['location:id,name', 'service:id,name'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate($perPage);

        if ($appointments->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay citas'], 200);
        }

        return response()->json([
            'data' => $appointments->items(),
            'meta' => [
                'current_page' => $appointments->currentPage(),
                'per_page' => $appointments->perPage(),
                'total' => $appointments->total(),
                'last_page' => $appointments->lastPage(),
                'by_status' => ListingAppointment::where('listing_id', $business->id)
                    ->groupBy('status')
                    ->selectRaw('status, count(*) as count')
                    ->pluck('count', 'status'),
            ],
        ]);
    }
}
