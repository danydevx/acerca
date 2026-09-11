<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingPackages\Http\Controllers\Admin\Api\PackageApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/packages', [PackageApiController::class, 'index'])
        ->name('listings.packages');
});
