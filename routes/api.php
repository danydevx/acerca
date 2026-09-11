<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Locations\Http\Controllers\Admin\LocationController;

Route::middleware(['api_key', 'throttle:api-key'])->group(function () {
    Route::get('/me', function (Request $request) {
        $user = $request->user();

        return response()->json([
            'id' => $user?->id,
            'name' => $user?->name,
            'email' => $user?->email,
        ]);
    })->name('api.me');
});

Route::get('v1/location-data/countries', [LocationController::class, 'getCountries']);
Route::get('v1/location-data/states', [LocationController::class, 'getStates']);
Route::get('v1/location-data/states/{countryCode}', [LocationController::class, 'getStates']);
Route::get('v1/location-data/municipalities/{stateCode}', [LocationController::class, 'getMunicipalities']);

require __DIR__ . '/api/v1/admin.php';
