<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\BusinessController;
use App\Http\Controllers\Api\V1\Admin\UserController;

Route::prefix('admin')->middleware(['auth:api', 'role:superadmin|admin'])->group(function () {

    Route::get('/businesses', [BusinessController::class, 'index'])
        ->name('api.v1.admin.listings.index');

    Route::get('/listings/{listing}', [BusinessController::class, 'show'])
        ->name('api.v1.admin.listings.show');

    Route::get('/listings/{listing}/stats', [BusinessController::class, 'stats'])
        ->name('api.v1.admin.listings.stats');

    Route::get('/users', [UserController::class, 'index'])
        ->name('api.v1.admin.users.index');

    Route::get('/users/{user}', [UserController::class, 'show'])
        ->name('api.v1.admin.users.show');

    Route::get('/users/{user}/businesses', [UserController::class, 'businesses'])
        ->name('api.v1.admin.users.businesses');
});
