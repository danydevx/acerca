<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingAppointments\Http\Controllers\Admin\Api\AppointmentApiController;
use Modules\ListingAppointments\Http\Controllers\Admin\Api\SlotApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/appointments', [AppointmentApiController::class, 'index'])
        ->name('listings.appointments');

    Route::get('/listings/{listing}/appointment-slots', [SlotApiController::class, 'index'])
        ->name('listings.appointment-slots');
});
