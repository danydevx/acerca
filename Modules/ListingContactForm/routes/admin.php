<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingContactForm\Http\Controllers\Admin\ListingContactFormController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->prefix('admin')
    ->name('admin.business.')
    ->group(function () {
        Route::get('/listings/{listing}/contact-form/submissions', [ListingContactFormController::class, 'submissions'])
            ->name('contact-form.submissions');
    });
