<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingProducts\Http\Controllers\Admin\Api\ProductApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/products', [ProductApiController::class, 'index'])
        ->name('listings.products');
});
