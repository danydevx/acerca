<?php

use Illuminate\Support\Facades\Route;
use Modules\Properties\Http\Controllers\Admin\Api\PropertyApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/properties', [PropertyApiController::class, 'index'])
        ->name('listings.properties');
});
