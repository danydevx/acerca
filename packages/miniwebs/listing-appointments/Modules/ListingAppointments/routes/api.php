<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingAppointments\Http\Controllers\AppointmentsController;
use Modules\ListingAppointments\Http\Controllers\Public\BookingWidgetController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('appointments', AppointmentsController::class)->names('appointments');
});

Route::prefix('book')->group(function () {
    Route::get('businesses/active', [BookingWidgetController::class, 'activeBusinesses'])
        ->name('book.businesses.active');

    Route::get('business/{businessSlug}/services', [BookingWidgetController::class, 'services'])
        ->name('book.services');

    Route::get('business/{businessSlug}/packages', [BookingWidgetController::class, 'packages'])
        ->name('book.packages');

    Route::get('business/{businessSlug}/slots', [BookingWidgetController::class, 'slots'])
        ->name('book.slots');

    Route::post('business/{businessSlug}', [BookingWidgetController::class, 'store'])
        ->name('book.store');
});
