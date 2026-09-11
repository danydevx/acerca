<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingReviews\Http\Controllers\Admin\ListingReviewController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/listings/{listing}/reviews', [ListingReviewController::class, 'index'])
            ->name('business.reviews.index');
        Route::get('/listings/{listing}/reviews/create', [ListingReviewController::class, 'create'])
            ->name('business.reviews.create');
        Route::post('/listings/{listing}/reviews', [ListingReviewController::class, 'store'])
            ->name('business.reviews.store');
        Route::get('/listings/{listing}/reviews/{review}/edit', [ListingReviewController::class, 'edit'])
            ->name('business.reviews.edit');
        Route::put('/listings/{listing}/reviews/{review}', [ListingReviewController::class, 'update'])
            ->name('business.reviews.update');
        Route::delete('/listings/{listing}/reviews/{review}', [ListingReviewController::class, 'destroy'])
            ->name('business.reviews.destroy');
    });
