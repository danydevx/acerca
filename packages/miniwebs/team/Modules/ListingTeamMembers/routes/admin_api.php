<?php

use Illuminate\Support\Facades\Route;
use Modules\ListingTeamMembers\Http\Controllers\Admin\Api\TeamMemberApiController;
use Modules\ListingTeamMembers\Http\Controllers\Admin\Api\TeamMemberPositionApiController;

Route::middleware(['auth:api', 'role:superadmin|admin'])->group(function () {
    Route::get('/listings/{listing}/team-members', [TeamMemberApiController::class, 'index'])
        ->name('listings.team-members');

    Route::get('/listings/{listing}/team-member-positions', [TeamMemberPositionApiController::class, 'index'])
        ->name('listings.team-member-positions');
});
