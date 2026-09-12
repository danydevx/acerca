<?php

use Illuminate\Support\Facades\Route;
use Modules\VCards\Http\Controllers\Public\VCardPublicController;

Route::get('/v/{slug}', [VCardPublicController::class, 'show'])
    ->name('vcards.public.show');
Route::post('/v/{slug}/unlock', [VCardPublicController::class, 'unlock'])
    ->name('vcards.public.unlock');
Route::get('/v/{slug}/qr', [VCardPublicController::class, 'qr'])
    ->name('vcards.public.qr');
Route::get('/v/{slug}/download', [VCardPublicController::class, 'download'])
    ->name('vcards.public.download');
