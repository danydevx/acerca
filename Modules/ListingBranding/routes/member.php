<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingBranding\Http\Controllers\Member\BrandingController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/branding', [BrandingController::class, 'index'])->name('branding.index');
        Route::post('/branding', [BrandingController::class, 'update'])->name('branding.update');
    });
