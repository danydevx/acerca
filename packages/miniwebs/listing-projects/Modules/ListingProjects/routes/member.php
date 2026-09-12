<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingProjects\Http\Controllers\Member\ProjectController;
use Modules\ListingProjects\Http\Controllers\Member\ProjectCategoryController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::post('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::post('/projects/{project}/clone', [ProjectController::class, 'clone'])->name('projects.clone');
        Route::post('/projects/reorder', [ProjectController::class, 'reorder'])->name('projects.reorder');
        Route::post('/projects/bulk-delete', [ProjectController::class, 'bulkDelete'])->name('projects.bulk-delete');

        Route::get('/project-categories', [ProjectCategoryController::class, 'index'])->name('project-categories.index');
        Route::post('/project-categories', [ProjectCategoryController::class, 'store'])->name('project-categories.store');
        Route::put('/project-categories/{category}', [ProjectCategoryController::class, 'update'])->name('project-categories.update');
        Route::delete('/project-categories/{category}', [ProjectCategoryController::class, 'destroy'])->name('project-categories.destroy');
    });
