<?php

namespace Modules\ListingTeamMembers\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingTeamMembers\Models\ListingTeamMember;
use Modules\ListingTeamMembers\Models\TeamMemberPosition;
use Modules\ListingTeamMembers\Policies\ListingTeamMemberPolicy;

class ListingTeamMembersServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingTeamMember::class, ListingTeamMemberPolicy::class);
        Gate::policy(TeamMemberPosition::class, ListingTeamMemberPolicy::class);
    }
}
