<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingHero\Http\Controllers\Admin\ListingHeroController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/listings/{listing}/hero', [ListingHeroController::class, 'index'])
            ->name('business.hero.index');
        Route::post('/listings/{listing}/hero', [ListingHeroController::class, 'update'])
            ->name('business.hero.update');
    });
