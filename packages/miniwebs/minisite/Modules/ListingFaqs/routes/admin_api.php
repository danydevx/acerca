<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingFaqs\Http\Controllers\Admin\Api\FaqApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/faqs', [FaqApiController::class, 'index'])
        ->name('listings.faqs');
});
