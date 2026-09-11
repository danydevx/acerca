<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingProducts\Http\Controllers\Member\ProductController;
use Modules\ListingProducts\Http\Controllers\Member\ProductCategoryController;
use Modules\ListingProducts\Http\Controllers\ListingProductImageController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/products/{product}/clone', [ProductController::class, 'clone'])->name('products.clone');
        Route::post('/products/reorder', [ProductController::class, 'reorder'])->name('products.reorder');
        Route::post('/products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
        Route::post('/products/{product}/images', [ListingProductImageController::class, 'store'])->name('products.images.store');
        Route::delete('/products/{product}/images/{image}', [ListingProductImageController::class, 'destroy'])->name('products.images.destroy');
    });

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.product.categories.')
    ->group(function () {
        Route::get('/product-categories', [ProductCategoryController::class, 'index'])->name('index');
        Route::post('/product-categories', [ProductCategoryController::class, 'store'])->name('store');
        Route::put('/product-categories/{category}', [ProductCategoryController::class, 'update'])->name('update');
        Route::delete('/product-categories/{category}', [ProductCategoryController::class, 'destroy'])->name('destroy');
    });
