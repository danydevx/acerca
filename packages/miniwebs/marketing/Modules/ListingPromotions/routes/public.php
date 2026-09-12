<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingPromotions\Http\Controllers\Public\PromotionVerificationController;

Route::middleware(['web'])
    ->group(function () {
        Route::get('/b/{slug}/verify/{promotionId}/{couponCode}', [PromotionVerificationController::class, 'verify'])
            ->name('public.promotion.verify');
    });
