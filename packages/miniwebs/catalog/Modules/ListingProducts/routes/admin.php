<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingProducts\Http\Controllers\Admin\ProductController;
use Modules\ListingProducts\Http\Controllers\Admin\ProductCategoryController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->prefix('admin/listings/{listing}')
    ->name('admin.business.')
    ->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        Route::get('/product-categories', [ProductCategoryController::class, 'index'])->name('product-categories.index');
        Route::post('/product-categories', [ProductCategoryController::class, 'store'])->name('product-categories.store');
        Route::put('/product-categories/{category}', [ProductCategoryController::class, 'update'])->name('product-categories.update');
        Route::delete('/product-categories/{category}', [ProductCategoryController::class, 'destroy'])->name('product-categories.destroy');
    });
