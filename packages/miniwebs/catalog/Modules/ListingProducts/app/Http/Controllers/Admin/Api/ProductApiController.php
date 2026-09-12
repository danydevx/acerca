<?php

namespace Modules\ListingProducts\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingProducts\Models\ListingProduct;

class ProductApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $products = ListingProduct::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'description', 'price', 'compare_at_price', 'sku', 'stock_quantity', 'is_active']);

        if ($products->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay productos configurados'], 200);
        }

        return response()->json([
            'data' => $products,
            'meta' => ['total' => $products->count()],
        ]);
    }
}
