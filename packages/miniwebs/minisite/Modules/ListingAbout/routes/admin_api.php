<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingAbout\Http\Controllers\Admin\Api\AboutApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/about', [AboutApiController::class, 'index'])
        ->name('listings.about');
});
