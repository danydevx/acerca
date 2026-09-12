<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingGallery\Http\Controllers\Admin\GalleryController;
use Modules\ListingGallery\Http\Controllers\Admin\GalleryGroupController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->prefix('admin/listings/{listing}')
    ->name('admin.business.')
    ->group(function () {
        Route::get('/galleries', [GalleryGroupController::class, 'index'])->name('galleries.index');
        Route::get('/galleries/create', [GalleryGroupController::class, 'create'])->name('galleries.create');
        Route::post('/galleries', [GalleryGroupController::class, 'store'])->name('galleries.store');
        Route::get('/galleries/{gallery}/edit', [GalleryGroupController::class, 'edit'])->name('galleries.edit');
        Route::put('/galleries/{gallery}', [GalleryGroupController::class, 'update'])->name('galleries.update');
        Route::delete('/galleries/{gallery}', [GalleryGroupController::class, 'destroy'])->name('galleries.destroy');
        Route::post('/galleries/{gallery}/set-primary', [GalleryGroupController::class, 'setPrimary'])->name('galleries.set-primary');

        Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
        Route::get('/gallery/{gallery}', [GalleryController::class, 'index'])->where('gallery', '[0-9]+')->name('gallery.show');
        Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
        Route::put('/gallery/{image}', [GalleryController::class, 'update'])->name('gallery.update');
        Route::delete('/gallery/{image}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    });
