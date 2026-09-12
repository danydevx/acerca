<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingReviews\Http\Controllers\Member\ReviewController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::post('/reviews/reorder', [ReviewController::class, 'reorder'])->name('reviews.reorder');
        Route::post('/reviews/bulk-delete', [ReviewController::class, 'bulkDelete'])->name('reviews.bulk-delete');
        Route::post('/reviews/{review}/clone', [ReviewController::class, 'clone'])->name('reviews.clone');
        Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });
