<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingBranding\Http\Controllers\Admin\Api\BrandingApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/branding', [BrandingApiController::class, 'index'])
        ->name('listings.branding');
});
