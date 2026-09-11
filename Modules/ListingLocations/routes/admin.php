<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingLocations\Http\Controllers\Admin\LocationController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->prefix('admin/listings/{listing}')
    ->name('admin.business.')
    ->group(function () {
        Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
        Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
        Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
        Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
        Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
        Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
    });
