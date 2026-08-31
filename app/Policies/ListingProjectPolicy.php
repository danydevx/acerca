<?php

namespace App\Policies;

use App\Models\User;
use Modules\ListingProjects\Models\ListingProject;
use Modules\Listings\Models\Listing;

class ListingProjectPolicy
{
    public function viewAny(User $user, Listing $business): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        return $user->id === $business->user_id;
    }

    public function create(User $user, Listing $business): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        return $user->id === $business->user_id;
    }

    public function update(User $user, ListingProject $project): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        return $user->id === $project->listing->user_id;
    }

    public function delete(User $user, ListingProject $project): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        return $user->id === $project->listing->user_id;
    }

    public function deleteAny(User $user, Listing $business): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        return $user->id === $business->user_id;
    }
}
