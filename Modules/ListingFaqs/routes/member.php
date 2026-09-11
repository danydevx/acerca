<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingFaqs\Http\Controllers\Member\FaqController;
use Modules\ListingFaqs\Http\Controllers\Member\FaqCategoryController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
        Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
        Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
        Route::get('/faqs/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
        Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');
        Route::post('/faqs/reorder', [FaqController::class, 'reorder'])->name('faqs.reorder');
        Route::post('/faqs/bulk-delete', [FaqController::class, 'bulkDelete'])->name('faqs.bulk-delete');
        Route::post('/faqs/{faq}/clone', [FaqController::class, 'clone'])->name('faqs.clone');

        Route::get('/faq-categories', [FaqCategoryController::class, 'index'])->name('faq-categories.index');
        Route::post('/faq-categories', [FaqCategoryController::class, 'store'])->name('faq-categories.store');
        Route::put('/faq-categories/{category}', [FaqCategoryController::class, 'update'])->name('faq-categories.update');
        Route::delete('/faq-categories/{category}', [FaqCategoryController::class, 'destroy'])->name('faq-categories.destroy');
    });
