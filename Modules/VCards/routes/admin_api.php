<?php

use Illuminate\Support\Facades\Route;
use Modules\VCards\Http\Controllers\Admin\Api\VCardApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/vcards', [VCardApiController::class, 'index'])
        ->name('listings.vcards');
});
