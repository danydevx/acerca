<?php

use Illuminate\Support\Facades\Route;
use Modules\Analytics\Http\Controllers\Public\AnalyticsCollectController;

Route::post('/analytics/collect', [AnalyticsCollectController::class, 'collect'])
    ->name('analytics.collect');
