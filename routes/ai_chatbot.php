<?php

use Modules\ListingAiChatbot\Http\Controllers\Member\AiChatbotController;
use Modules\ListingAiChatbot\Http\Controllers\Member\ConversationHistoryController;
use Modules\ListingAiChatbot\Http\Controllers\Member\ChatbotAnalyticsController;
use Modules\ListingAiChatbot\Http\Controllers\Member\ChatbotPresetsController;
use Modules\ListingAiChatbot\Http\Controllers\Member\ChatbotPersonalityController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}/ai-chatbot')
    ->name('member.listings.listing-aichatbot.')
    ->group(function () {
        Route::get('/', [AiChatbotController::class, 'index'])->name('index');
        Route::post('/settings', [AiChatbotController::class, 'saveSettings'])->name('settings');
        Route::post('/contexts', [AiChatbotController::class, 'storeContext'])->name('contexts.store');
        Route::put('/contexts/{contextId}', [AiChatbotController::class, 'updateContext'])->name('contexts.update');
        Route::delete('/contexts/{contextId}', [AiChatbotController::class, 'destroyContext'])->name('contexts.destroy');
        Route::get('/embeddings-json', [AiChatbotController::class, 'embeddingsJson'])->name('embeddings.json');
        Route::delete('/embeddings/{type}', [AiChatbotController::class, 'destroyEmbeddings'])->name('embeddings.destroy');
        Route::delete('/embedding/{id}', [AiChatbotController::class, 'destroyEmbedding'])->name('embedding.destroy');
        Route::post('/reindex', [AiChatbotController::class, 'reindex'])->name('reindex');
        Route::post('/extract-url', [AiChatbotController::class, 'extractUrl'])->name('extract-url');
        Route::get('/history', [ConversationHistoryController::class, 'index'])->name('history');
        Route::get('/history/{sessionId}', [ConversationHistoryController::class, 'show'])->name('history.show');
        Route::get('/analytics', [ChatbotAnalyticsController::class, 'index'])->name('analytics');
        Route::get('/analytics-json', [ChatbotAnalyticsController::class, 'indexJson'])->name('analytics-json');

        Route::get('/presets', [ChatbotPresetsController::class, 'index'])->name('presets.index');
        Route::get('/presets/create', [ChatbotPresetsController::class, 'create'])->name('presets.create');
        Route::post('/presets', [ChatbotPresetsController::class, 'store'])->name('presets.store');
        Route::get('/presets/{preset}/edit', [ChatbotPresetsController::class, 'edit'])->name('presets.edit');
        Route::put('/presets/{preset}', [ChatbotPresetsController::class, 'update'])->name('presets.update');
        Route::delete('/presets/{preset}', [ChatbotPresetsController::class, 'destroy'])->name('presets.destroy');
        Route::post('/presets/{preset}/duplicate', [ChatbotPresetsController::class, 'duplicate'])->name('presets.duplicate');

        Route::get('/personalities', [ChatbotPersonalityController::class, 'index'])->name('personalities.index');
        Route::get('/personalities/create', [ChatbotPersonalityController::class, 'create'])->name('personalities.create');
        Route::post('/personalities', [ChatbotPersonalityController::class, 'store'])->name('personalities.store');
        Route::get('/personalities/{personality}/edit', [ChatbotPersonalityController::class, 'edit'])->name('personalities.edit');
        Route::put('/personalities/{personality}', [ChatbotPersonalityController::class, 'update'])->name('personalities.update');
        Route::delete('/personalities/{personality}', [ChatbotPersonalityController::class, 'destroy'])->name('personalities.destroy');
    });
