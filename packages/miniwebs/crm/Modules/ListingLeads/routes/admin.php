<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingLeads\Http\Controllers\Admin\ListingLeadsController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/listings/{listing}/leads', [ListingLeadsController::class, 'index'])
            ->name('business.leads.index');
        Route::get('/listings/{listing}/leads/create', [ListingLeadsController::class, 'create'])
            ->name('business.leads.create');
        Route::post('/listings/{listing}/leads', [ListingLeadsController::class, 'store'])
            ->name('business.leads.store');
        Route::get('/listings/{listing}/leads/{lead}/edit', [ListingLeadsController::class, 'edit'])
            ->name('business.leads.edit');
        Route::put('/listings/{listing}/leads/{lead}', [ListingLeadsController::class, 'update'])
            ->name('business.leads.update');
        Route::delete('/listings/{listing}/leads/{lead}', [ListingLeadsController::class, 'destroy'])
            ->name('business.leads.destroy');
        Route::get('/listings/{listing}/leads/{lead}', [ListingLeadsController::class, 'show'])
            ->name('business.leads.show');
    });
