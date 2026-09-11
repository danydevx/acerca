<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingLeads\Http\Controllers\Admin\Api\LeadApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/leads', [LeadApiController::class, 'index'])
        ->name('listings.leads');
});
