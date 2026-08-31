<?php

namespace App\Policies;

use App\Models\User;
use Modules\ListingProjects\Models\ListingProjectCategory;
use Modules\Listings\Models\Listing;

class ListingProjectCategoryPolicy
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

    public function update(User $user, ListingProjectCategory $category): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        return $user->id === $category->listing->user_id;
    }

    public function delete(User $user, ListingProjectCategory $category): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        return $user->id === $category->listing->user_id;
    }
}
