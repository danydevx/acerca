<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingHero\Http\Controllers\Member\HeroController;

Route::get('/member/listings/{listing}/hero', [HeroController::class, 'index'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.hero.index');

Route::post('/member/listings/{listing}/hero', [HeroController::class, 'update'])
    ->middleware(['auth', 'verified', 'active', 'role:member'])
    ->name('member.listings.hero.update');
