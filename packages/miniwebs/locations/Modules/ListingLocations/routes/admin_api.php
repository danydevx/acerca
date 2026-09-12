<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingLocations\Http\Controllers\Admin\Api\LocationApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/locations', [LocationApiController::class, 'index'])
        ->name('listings.locations');
});
