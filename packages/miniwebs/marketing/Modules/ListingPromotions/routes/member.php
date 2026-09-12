<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingPromotions\Http\Controllers\Member\PromotionController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
        Route::get('/promotions/create', [PromotionController::class, 'create'])->name('promotions.create');
        Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');
        Route::get('/promotions/{promotion}/edit', [PromotionController::class, 'edit'])->name('promotions.edit');
        Route::put('/promotions/{promotion}', [PromotionController::class, 'update'])->name('promotions.update');
        Route::delete('/promotions/{promotion}', [PromotionController::class, 'destroy'])->name('promotions.destroy');
        Route::post('/promotions/reorder', [PromotionController::class, 'reorder'])->name('promotions.reorder');
        Route::post('/promotions/bulk-delete', [PromotionController::class, 'bulkDelete'])->name('promotions.bulk-delete');
        Route::post('/promotions/{promotion}/clone', [PromotionController::class, 'clone'])->name('promotions.clone');
        Route::post('/promotions/{promotion}/regenerate-qr', [PromotionController::class, 'regenerateQrCode'])->name('promotions.regenerate-qr');
    });
