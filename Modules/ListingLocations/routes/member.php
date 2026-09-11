<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('locations.')
    ->group(function () {
        Route::get('/locations', [\Modules\ListingLocations\Http\Controllers\Member\LocationController::class, 'index'])->name('index');
        Route::get('/locations/create', [\Modules\ListingLocations\Http\Controllers\Member\LocationController::class, 'create'])->name('create');
        Route::post('/locations', [\Modules\ListingLocations\Http\Controllers\Member\LocationController::class, 'store'])->name('store');
        Route::get('/locations/{location}/edit', [\Modules\ListingLocations\Http\Controllers\Member\LocationController::class, 'edit'])->name('edit');
        Route::put('/locations/{location}', [\Modules\ListingLocations\Http\Controllers\Member\LocationController::class, 'update'])->name('update');
        Route::delete('/locations/{location}', [\Modules\ListingLocations\Http\Controllers\Member\LocationController::class, 'destroy'])->name('destroy');
        Route::post('/locations/bulk-delete', [\Modules\ListingLocations\Http\Controllers\Member\LocationController::class, 'bulkDelete'])->name('bulk-delete');
    });
