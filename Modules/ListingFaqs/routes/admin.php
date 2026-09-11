<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingFaqs\Http\Controllers\Admin\FaqController;
use Modules\ListingFaqs\Http\Controllers\Admin\FaqCategoryController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->prefix('admin/listings/{listing}')
    ->name('admin.business.')
    ->group(function () {
        Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
        Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
        Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
        Route::get('/faqs/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
        Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');

        Route::get('/faq-categories', [FaqCategoryController::class, 'index'])->name('faq-categories.index');
        Route::post('/faq-categories', [FaqCategoryController::class, 'store'])->name('faq-categories.store');
        Route::put('/faq-categories/{category}', [FaqCategoryController::class, 'update'])->name('faq-categories.update');
        Route::delete('/faq-categories/{category}', [FaqCategoryController::class, 'destroy'])->name('faq-categories.destroy');
    });
