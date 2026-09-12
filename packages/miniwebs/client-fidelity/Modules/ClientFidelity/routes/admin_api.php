<?php

use Illuminate\Support\Facades\Route;
use Modules\ClientFidelity\Http\Controllers\Admin\Api\FidelityCardApiController;
use Modules\ClientFidelity\Http\Controllers\Admin\Api\FidelityRewardApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/fidelity-cards', [FidelityCardApiController::class, 'index'])
        ->name('listings.fidelity-cards');

    Route::get('/listings/{listing}/fidelity-rewards', [FidelityRewardApiController::class, 'index'])
        ->name('listings.fidelity-rewards');
});
