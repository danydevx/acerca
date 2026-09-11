<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingServices\Http\Controllers\Admin\Api\ServiceApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/services', [ServiceApiController::class, 'index'])
        ->name('listings.services');
});
