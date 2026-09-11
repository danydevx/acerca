<?php

namespace Modules\ListingTeamMembers\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingTeamMembers\Models\ListingTeamMember;
use Modules\ListingTeamMembers\Models\TeamMemberPosition;
use Modules\ListingTeamMembers\Policies\ListingTeamMemberPolicy;

class ListingTeamMembersServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingTeamMembers';
    protected string $nameLower = 'listingteammembers';

    protected array $providers = [
        RouteServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingTeamMember::class, ListingTeamMemberPolicy::class);
        Gate::policy(TeamMemberPosition::class, ListingTeamMemberPolicy::class);
    }
}
