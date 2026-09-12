<?php

namespace Modules\ListingRestaurantMenu\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingRestaurantMenu\Entities\MenuCategory;

class MenuCategoryApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $categories = MenuCategory::where('listing_id', $business->id)
            ->with(['parent:id,title', 'children:id,parent_id,title'])
            ->orderBy('sort_order')
            ->get();

        if ($categories->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay categorias'], 200);
        }

        return response()->json([
            'data' => $categories,
            'meta' => ['total' => $categories->count()],
        ]);
    }
}
