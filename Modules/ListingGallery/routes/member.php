<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingGallery\Http\Controllers\Member\GalleryController;
use Modules\ListingGallery\Http\Controllers\Member\GalleryGroupController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/galleries', [GalleryGroupController::class, 'index'])->name('galleries.index');
        Route::get('/galleries/create', [GalleryGroupController::class, 'create'])->name('galleries.create');
        Route::post('/galleries', [GalleryGroupController::class, 'store'])->name('galleries.store');
        Route::get('/galleries/{gallery}/edit', [GalleryGroupController::class, 'edit'])->name('galleries.edit');
        Route::put('/galleries/{gallery}', [GalleryGroupController::class, 'update'])->name('galleries.update');
        Route::delete('/galleries/{gallery}', [GalleryGroupController::class, 'destroy'])->name('galleries.destroy');
        Route::post('/galleries/{gallery}/set-primary', [GalleryGroupController::class, 'setPrimary'])->name('galleries.set-primary');

        Route::get('/gallery', [GalleryGroupController::class, 'index'])->name('gallery.index');
        Route::get('/gallery/{gallery}', [GalleryController::class, 'show'])->name('gallery.show');
        Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
        Route::put('/gallery/{image}', [GalleryController::class, 'update'])->name('gallery.update');
        Route::delete('/gallery/{image}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
        Route::post('/gallery/reorder', [GalleryController::class, 'reorder'])->name('gallery.reorder');
        Route::post('/gallery/bulk-delete', [GalleryController::class, 'bulkDelete'])->name('gallery.bulk-delete');
    });
