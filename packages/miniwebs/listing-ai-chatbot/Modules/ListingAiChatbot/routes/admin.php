<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingAiChatbot\Http\Controllers\Admin\ListingAiChatbotController;

Route::middleware(['auth', 'admin_or_user:1'])
    ->name('admin.')
    ->group(function () {
        Route::get('/listings/{listing}/ai-chatbot', [ListingAiChatbotController::class, 'index'])
            ->name('business.ai-chatbot.index');
    });
