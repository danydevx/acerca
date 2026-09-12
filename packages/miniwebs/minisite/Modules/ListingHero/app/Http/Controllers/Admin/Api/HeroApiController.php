<?php

namespace Modules\ListingHero\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingHero\Models\ListingHero;

class HeroApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $hero = ListingHero::where('listing_id', $business->id)->first([
            'id',
            'title',
            'subtitle',
            'description',
            'background_image',
            'background_color',
            'cta_text',
            'cta_url',
            'cta_second_text',
            'cta_second_url',
            'is_active',
        ]);

        if (!$hero) {
            return response()->json(['data' => null, 'message' => 'No hay configuracion de hero'], 200);
        }

        return response()->json(['data' => $hero]);
    }
}
