<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingServices\Http\Controllers\Member\ServiceController;
use Modules\ListingServices\Http\Controllers\Member\ServiceCategoryController;
use Modules\ListingServices\Http\Controllers\ServiceImageController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
        Route::post('/services/{service}/clone', [ServiceController::class, 'clone'])->name('services.clone');
        Route::post('/services/reorder', [ServiceController::class, 'reorder'])->name('services.reorder');
        Route::post('/services/{service}/images', [ServiceImageController::class, 'store'])->name('services.images.store');
        Route::delete('/services/{service}/images/{image}', [ServiceImageController::class, 'destroy'])->name('services.images.destroy');

        Route::get('/service-categories', [ServiceCategoryController::class, 'index'])->name('service-categories.index');
        Route::post('/service-categories', [ServiceCategoryController::class, 'store'])->name('service-categories.store');
        Route::put('/service-categories/{category}', [ServiceCategoryController::class, 'update'])->name('service-categories.update');
        Route::delete('/service-categories/{category}', [ServiceCategoryController::class, 'destroy'])->name('service-categories.destroy');
    });
