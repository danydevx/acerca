<?php

use Illuminate\Support\Facades\Route;
use Modules\Analytics\Http\Controllers\Member\AnalyticsController;

Route::get('/', [AnalyticsController::class, 'index'])->name('index');
Route::get('/data', [AnalyticsController::class, 'data'])->name('data');
Route::get('/settings', [AnalyticsController::class, 'settings'])->name('settings');
Route::post('/settings', [AnalyticsController::class, 'saveSettings'])->name('settings.save');
