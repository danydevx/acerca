<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingAppointments\Http\Controllers\Public\DirectoryAppointmentController;
use Modules\ListingAppointments\Http\Controllers\Public\MinisiteBookingController;

Route::middleware(['web'])->group(function () {
    Route::post('/negocios/{slug}/appointment', [DirectoryAppointmentController::class, 'store'])
        ->name('directory.appointment.store');

    Route::get('/b/{slug}/book', [MinisiteBookingController::class, 'book'])
        ->name('public.business.book');
    Route::post('/b/{slug}/book', [MinisiteBookingController::class, 'store'])
        ->name('public.business.booking.store');
    Route::get('/b/{slug}/book/success', [MinisiteBookingController::class, 'success'])
        ->name('public.business.booking.success');
});
