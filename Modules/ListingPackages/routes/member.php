<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingPackages\Http\Controllers\Member\PackageController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
        Route::get('/packages/create', [PackageController::class, 'create'])->name('packages.create');
        Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
        Route::post('/packages/reorder', [PackageController::class, 'reorder'])->name('packages.reorder');
        Route::post('/packages/bulk-delete', [PackageController::class, 'bulkDelete'])->name('packages.bulk-delete');
        Route::get('/packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
        Route::post('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
        Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');
        Route::post('/packages/{package}/clone', [PackageController::class, 'clone'])->name('packages.clone');
    });
