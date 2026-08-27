<?php

namespace App\Policies;

use App\Models\User;
use Modules\Analytics\Models\AnalyticsSetting;
use Modules\Listings\Models\Listing;

class AnalyticsSettingPolicy
{
    public function viewAny(User $user, Listing $listing): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        return $user->id === $listing->user_id;
    }

    public function view(User $user, AnalyticsSetting $setting): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        return $user->id === $setting->listing->user_id;
    }

    public function update(User $user, AnalyticsSetting $setting): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        return $user->id === $setting->listing->user_id;
    }

    public function create(User $user, Listing $listing): bool
    {
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            return true;
        }

        return $user->id === $listing->user_id;
    }
}
