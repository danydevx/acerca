<?php

namespace Modules\ListingClients\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingClients\Models\ListingClient;

class ClientApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $clients = ListingClient::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($clients->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay clientes'], 200);
        }

        return response()->json([
            'data' => $clients,
            'meta' => ['total' => $clients->count()],
        ]);
    }
}
