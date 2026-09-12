<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingSeo\Http\Controllers\Admin\Api\SeoApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/seo', [SeoApiController::class, 'index'])
        ->name('listings.seo');
});
