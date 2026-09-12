<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingPromotions\Http\Controllers\Admin\ListingPromotionController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/listings/{listing}/promotions', [ListingPromotionController::class, 'index'])
            ->name('business.promotions.index');
        Route::get('/listings/{listing}/promotions/create', [ListingPromotionController::class, 'create'])
            ->name('business.promotions.create');
        Route::post('/listings/{listing}/promotions', [ListingPromotionController::class, 'store'])
            ->name('business.promotions.store');
        Route::get('/listings/{listing}/promotions/{promotion}/edit', [ListingPromotionController::class, 'edit'])
            ->name('business.promotions.edit');
        Route::put('/listings/{listing}/promotions/{promotion}', [ListingPromotionController::class, 'update'])
            ->name('business.promotions.update');
        Route::delete('/listings/{listing}/promotions/{promotion}', [ListingPromotionController::class, 'destroy'])
            ->name('business.promotions.destroy');
    });
