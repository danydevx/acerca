<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingOfficeHours\Http\Controllers\Admin\Api\OfficeHoursApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/office-hours', [OfficeHoursApiController::class, 'index'])
        ->name('listings.office-hours');
});
