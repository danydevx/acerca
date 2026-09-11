<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingReviews\Http\Controllers\Admin\Api\ReviewApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/reviews', [ReviewApiController::class, 'index'])
        ->name('listings.reviews');
});
