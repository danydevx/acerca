<?php

namespace Modules\ListingReviews\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingReviews\Models\ListingReview;

class ReviewApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $reviews = ListingReview::where('listing_id', $business->id)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'reviewer_name', 'rating', 'comment', 'is_approved', 'created_at']);

        if ($reviews->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay reviews'], 200);
        }

        return response()->json([
            'data' => $reviews,
            'meta' => [
                'total' => $reviews->count(),
                'average_rating' => $reviews->avg('rating'),
            ],
        ]);
    }
}
