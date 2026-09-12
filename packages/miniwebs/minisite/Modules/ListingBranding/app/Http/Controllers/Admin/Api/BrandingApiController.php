<?php

namespace Modules\ListingBranding\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingBranding\Models\ListingBrandingSetting;

class BrandingApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $branding = ListingBrandingSetting::where('listing_id', $business->id)->first([
            'id',
            'colors',
            'fonts',
            'custom_font_url',
            'dark_mode',
            'buttons_style',
        ]);

        if (!$branding) {
            return response()->json(['data' => null, 'message' => 'No hay configuracion de marca'], 200);
        }

        return response()->json(['data' => $branding]);
    }
}
