<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingClients\Http\Controllers\Admin\Api\ClientApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/clients', [ClientApiController::class, 'index'])
        ->name('listings.clients');
});
