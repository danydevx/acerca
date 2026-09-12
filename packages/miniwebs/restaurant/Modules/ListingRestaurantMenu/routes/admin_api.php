<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingRestaurantMenu\Http\Controllers\Admin\Api\MenuCategoryApiController;
use Modules\ListingRestaurantMenu\Http\Controllers\Admin\Api\MenuProductApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/menu-categories', [MenuCategoryApiController::class, 'index'])
        ->name('listings.menu-categories');

    Route::get('/listings/{listing}/menu-products', [MenuProductApiController::class, 'index'])
        ->name('listings.menu-products');
});
