<?php

namespace Modules\ListingSeo\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingSeo\Models\ListingSeoSetting;

class SeoApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $seo = ListingSeoSetting::where('listing_id', $business->id)->first([
            'id',
            'seo_title',
            'seo_description',
            'focus_keyword',
            'allow_indexing',
            'follow_links',
            'include_in_sitemap',
            'canonical_url',
            'og_title',
            'og_description',
            'og_image',
            'og_image_alt',
            'schema_enabled',
            'schema_type',
        ]);

        if (!$seo) {
            return response()->json(['data' => null, 'message' => 'No hay configuracion SEO'], 200);
        }

        return response()->json(['data' => $seo]);
    }
}
