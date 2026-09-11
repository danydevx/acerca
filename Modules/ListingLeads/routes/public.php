<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingLeads\Http\Controllers\Public\DirectoryContactController;
use Modules\ListingLeads\Http\Controllers\Public\MinisiteContactController;

Route::middleware(['web'])->group(function () {
    Route::post('/negocios/{slug}/contact', [DirectoryContactController::class, 'store'])
        ->name('directory.contact.store');

    Route::get('/b/{slug}/contact', [MinisiteContactController::class, 'contact'])
        ->name('public.business.contact');
    Route::post('/b/{slug}/contact', [MinisiteContactController::class, 'storeContact'])
        ->name('public.business.contact.store');
    Route::get('/b/{slug}/form/{shortcode}', [MinisiteContactController::class, 'formByShortcode'])
        ->name('public.business.form.shortcode');
    Route::post('/b/{slug}/form/{shortcode}', [MinisiteContactController::class, 'storeFormByShortcode'])
        ->name('public.business.form.shortcode.store');
});
