<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingAbout\Http\Controllers\Member\AboutController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/about', [AboutController::class, 'index'])->name('about.index');
        Route::post('/about', [AboutController::class, 'update'])->name('about.update');
    });
