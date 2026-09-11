<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingSocialMedia\Http\Controllers\Member\SocialNetworkController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/social-networks', [SocialNetworkController::class, 'index'])->name('social-networks.index');
        Route::post('/social-networks', [SocialNetworkController::class, 'store'])->name('social-networks.store');
        Route::post('/social-networks/reorder', [SocialNetworkController::class, 'reorder'])->name('social-networks.reorder');
        Route::post('/social-networks/{socialNetwork}', [SocialNetworkController::class, 'update'])->name('social-networks.update');
        Route::delete('/social-networks/{socialNetwork}', [SocialNetworkController::class, 'destroy'])->name('social-networks.destroy');
    });
