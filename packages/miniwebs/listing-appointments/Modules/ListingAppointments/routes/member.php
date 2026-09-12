<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingAppointments\Http\Controllers\Member\AppointmentController;
use Modules\ListingAppointments\Http\Controllers\Member\AvailabilityController;
use Modules\ListingAppointments\Http\Controllers\Member\SlotController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/appointments/availability', [AvailabilityController::class, 'index'])->name('appointments.availability');
        Route::put('/appointments/availability/weekly', [AvailabilityController::class, 'updateWeekly'])->name('appointments.availability.weekly');
        Route::post('/appointments/availability/exceptions', [AvailabilityController::class, 'storeException'])->name('appointments.availability.exceptions.store');
        Route::delete('/appointments/availability/exceptions/{exception}', [AvailabilityController::class, 'destroyException'])->name('appointments.availability.exceptions.destroy');
        Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
        Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
        Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::put('/appointments/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
        Route::post('/appointments/bulk-delete', [AppointmentController::class, 'bulkDelete'])->name('appointments.bulk-delete');

        Route::get('/slots', [SlotController::class, 'index'])->name('slots.index');
        Route::post('/slots', [SlotController::class, 'store'])->name('slots.store');
        Route::put('/slots/{slot}', [SlotController::class, 'update'])->name('slots.update');
        Route::delete('/slots/{slot}', [SlotController::class, 'destroy'])->name('slots.destroy');
    });
