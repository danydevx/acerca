<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingGallery\Http\Controllers\Admin\Api\GalleryApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/gallery', [GalleryApiController::class, 'index'])
        ->name('listings.gallery');
});
