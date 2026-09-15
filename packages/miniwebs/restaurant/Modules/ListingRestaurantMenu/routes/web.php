<?php

use Illuminate\Support\Facades\Route;
use Modules\Listings\Models\Listing;
use Modules\ListingRestaurantMenu\Http\Controllers\Admin\MenuCategoryController;
use Modules\ListingRestaurantMenu\Http\Controllers\Admin\MenuProductController;
use Modules\ListingRestaurantMenu\Http\Controllers\Admin\MenuProductImageController;
use Modules\ListingRestaurantMenu\Http\Controllers\Admin\MenuProductVariantController;
use Modules\ListingRestaurantMenu\Http\Controllers\Member\MenuCategoryController as MemberMenuCategoryController;
use Modules\ListingRestaurantMenu\Http\Controllers\Member\MenuProductController as MemberMenuProductController;
use Modules\ListingRestaurantMenu\Http\Controllers\Member\MenuProductImageController as MemberMenuProductImageController;
use Modules\ListingRestaurantMenu\Http\Controllers\Member\MenuProductVariantController as MemberMenuProductVariantController;
use Modules\ListingRestaurantMenu\Http\Controllers\Public\MenuController;

Route::prefix('admin/listings/{listing}')->middleware(['auth', 'role:superadmin|admin'])->group(function () {
    Route::resource('menu-categories', MenuCategoryController::class)->names([
        'index' => 'admin.menu.categories.index',
        'store' => 'admin.menu.categories.store',
        'update' => 'admin.menu.categories.update',
        'destroy' => 'admin.menu.categories.destroy',
    ]);

    Route::resource('menu-products', MenuProductController::class)->names([
        'index' => 'admin.menu.products.index',
        'store' => 'admin.menu.products.store',
        'update' => 'admin.menu.products.update',
        'destroy' => 'admin.menu.products.destroy',
    ]);

    Route::post('menu-products/{product}/variants', [MenuProductVariantController::class, 'store'])->name('admin.menu.products.variants.store');
    Route::put('menu-products/{product}/variants/{variant}', [MenuProductVariantController::class, 'update'])->name('admin.menu.products.variants.update');
    Route::delete('menu-products/{product}/variants/{variant}', [MenuProductVariantController::class, 'destroy'])->name('admin.menu.products.variants.destroy');

    Route::post('menu-products/{product}/images', [MenuProductImageController::class, 'store'])->name('admin.menu.products.images.store');
    Route::put('menu-products/{product}/images/{image}', [MenuProductImageController::class, 'update'])->name('admin.menu.products.images.update');
    Route::delete('menu-products/{product}/images/{image}', [MenuProductImageController::class, 'destroy'])->name('admin.menu.products.images.destroy');
});

Route::prefix('member/listings/{listing}')->middleware(['auth', 'role:superadmin|admin|member'])->group(function () {
    Route::resource('menu-categories', MemberMenuCategoryController::class)->names([
        'index' => 'member.menu.categories.index',
        'store' => 'member.menu.categories.store',
        'update' => 'member.menu.categories.update',
        'destroy' => 'member.menu.categories.destroy',
    ]);

    Route::resource('menu-products', MemberMenuProductController::class)->names([
        'index' => 'member.menu.products.index',
        'store' => 'member.menu.products.store',
        'update' => 'member.menu.products.update',
        'destroy' => 'member.menu.products.destroy',
    ]);

    Route::post('menu-products/{product}/variants', [MemberMenuProductVariantController::class, 'store'])->name('member.menu.products.variants.store');
    Route::put('menu-products/{product}/variants/{variant}', [MemberMenuProductVariantController::class, 'update'])->name('member.menu.products.variants.update');
    Route::delete('menu-products/{product}/variants/{variant}', [MemberMenuProductVariantController::class, 'destroy'])->name('member.menu.products.variants.destroy');

    Route::post('menu-products/{product}/images', [MemberMenuProductImageController::class, 'store'])->name('member.menu.products.images.store');
    Route::put('menu-products/{product}/images/{image}', [MemberMenuProductImageController::class, 'update'])->name('member.menu.products.images.update');
    Route::delete('menu-products/{product}/images/{image}', [MemberMenuProductImageController::class, 'destroy'])->name('member.menu.products.images.destroy');

    Route::post('menu-products/{product}/clone', [MemberMenuProductController::class, 'clone'])->name('member.menu.products.clone');
});

Route::get('{businessSlug}/menu', [MenuController::class, 'show'])->name('public.menu.show');
