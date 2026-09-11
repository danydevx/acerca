<?php

use Illuminate\Support\Facades\Route;
use Modules\Listings\Http\Controllers\Member\BusinessController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/member/listings/create', [BusinessController::class, 'create'])
        ->name('member.listings.create');

    Route::post('/member/listings', [BusinessController::class, 'store'])
        ->name('member.listings.store');

    Route::get('/member/listings/{listing}/edit', [BusinessController::class, 'edit'])
        ->name('member.listings.edit');

    Route::put('/member/listings/{listing}', [BusinessController::class, 'update'])
        ->name('member.listings.update');
});
