<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingAppointments\Http\Controllers\Admin\SlotController;
use Modules\ListingAppointments\Http\Controllers\Admin\AppointmentController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->prefix('admin')
    ->name('admin.business.')
    ->group(function () {
        Route::get('/listings/{listing}/slots', [SlotController::class, 'index'])->name('slots.index');
        Route::post('/listings/{listing}/slots', [SlotController::class, 'store'])->name('slots.store');
        Route::put('/listings/{listing}/slots/{slot}', [SlotController::class, 'update'])->name('slots.update');
        Route::delete('/listings/{listing}/slots/{slot}', [SlotController::class, 'destroy'])->name('slots.destroy');

        Route::get('/listings/{listing}/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/listings/{listing}/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/listings/{listing}/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/listings/{listing}/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
        Route::get('/listings/{listing}/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('/listings/{listing}/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('/listings/{listing}/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
        Route::post('/listings/{listing}/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    });
