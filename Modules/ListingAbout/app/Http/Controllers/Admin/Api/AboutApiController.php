<?php

namespace Modules\ListingAbout\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Listings\Models\Listing;
use Modules\ListingAbout\Models\ListingAbout;

class AboutApiController extends Controller
{
    public function index(Listing $business): JsonResponse
    {
        $about = ListingAbout::where('listing_id', $business->id)->first([
            'id',
            'title',
            'description',
            'image',
            'video_url',
            'mission',
            'vision',
            'values',
        ]);

        if (!$about) {
            return response()->json(['data' => null, 'message' => 'No hay seccion about'], 200);
        }

        return response()->json(['data' => $about]);
    }
}
