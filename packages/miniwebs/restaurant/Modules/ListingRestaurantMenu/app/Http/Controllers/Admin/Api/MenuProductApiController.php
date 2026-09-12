<?php

namespace Modules\ListingRestaurantMenu\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingRestaurantMenu\Entities\MenuProduct;

class MenuProductApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $products = MenuProduct::where('listing_id', $business->id)
            ->with(['category:id,title', 'variants', 'images'])
            ->orderBy('sort_order')
            ->get();

        if ($products->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay productos'], 200);
        }

        return response()->json([
            'data' => $products,
            'meta' => ['total' => $products->count()],
        ]);
    }
}
