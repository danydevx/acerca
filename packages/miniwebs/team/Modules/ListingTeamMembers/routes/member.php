<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingTeamMembers\Http\Controllers\Member\TeamMemberController;
use Modules\ListingTeamMembers\Http\Controllers\Member\TeamMemberPositionController;

Route::middleware(['auth', 'verified', 'active', 'role:member'])
    ->prefix('member/listings/{listing}')
    ->name('member.listings.')
    ->group(function () {
        Route::get('/team-members', [TeamMemberController::class, 'index'])->name('team-members.index');
        Route::get('/team-members/create', [TeamMemberController::class, 'create'])->name('team-members.create');
        Route::post('/team-members', [TeamMemberController::class, 'store'])->name('team-members.store');
        Route::get('/team-members/{team_member}/edit', [TeamMemberController::class, 'edit'])->name('team-members.edit');
        Route::post('/team-members/{team_member}', [TeamMemberController::class, 'update'])->name('team-members.update');
        Route::delete('/team-members/{team_member}', [TeamMemberController::class, 'destroy'])->name('team-members.destroy');
        Route::post('/team-members/reorder', [TeamMemberController::class, 'reorder'])->name('team-members.reorder');
        Route::post('/team-members/bulk-delete', [TeamMemberController::class, 'bulkDelete'])->name('team-members.bulk-delete');

        Route::get('/team-member-positions', [TeamMemberPositionController::class, 'index'])->name('team-member-positions.index');
        Route::post('/team-member-positions', [TeamMemberPositionController::class, 'store'])->name('team-member-positions.store');
        Route::put('/team-member-positions/{position}', [TeamMemberPositionController::class, 'update'])->name('team-member-positions.update');
        Route::delete('/team-member-positions/{position}', [TeamMemberPositionController::class, 'destroy'])->name('team-member-positions.destroy');
    });
