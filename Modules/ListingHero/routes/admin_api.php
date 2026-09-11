<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingHero\Http\Controllers\Admin\Api\HeroApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/hero', [HeroApiController::class, 'index'])
        ->name('listings.hero');
});
