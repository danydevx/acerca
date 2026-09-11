<?php

namespace Modules\ListingFaqs\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingFaqs\Models\ListingFaq;

class FaqApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $faqs = ListingFaq::where('listing_id', $business->id)
            ->with('category:id,name')
            ->orderBy('order', 'asc')
            ->get(['id', 'category_id', 'question', 'answer', 'is_active', 'order']);

        if ($faqs->isEmpty()) {
            return response()->json(['data' => null, 'message' => 'No hay preguntas frecuentes configuradas'], 200);
        }

        return response()->json([
            'data' => $faqs,
            'meta' => ['total' => $faqs->count()],
        ]);
    }
}
