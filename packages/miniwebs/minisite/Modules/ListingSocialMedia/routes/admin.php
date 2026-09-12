<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingSocialMedia\Http\Controllers\Admin\ListingSocialNetworkController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/listings/{listing}/social-networks', [ListingSocialNetworkController::class, 'index'])
            ->name('business.social-networks.index');
        Route::post('/listings/{listing}/social-networks', [ListingSocialNetworkController::class, 'store'])
            ->name('business.social-networks.store');
        Route::post('/listings/{listing}/social-networks/{socialNetwork}', [ListingSocialNetworkController::class, 'update'])
            ->name('business.social-networks.update');
        Route::delete('/listings/{listing}/social-networks/{socialNetwork}', [ListingSocialNetworkController::class, 'destroy'])
            ->name('business.social-networks.destroy');
    });
