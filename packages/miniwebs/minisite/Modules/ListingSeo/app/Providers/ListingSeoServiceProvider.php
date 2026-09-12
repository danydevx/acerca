<?php

namespace Modules\ListingSeo\Providers;

use Illuminate\Support\Facades\Gate;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\ListingSeo\Models\ListingSeoSetting;
use Modules\ListingSeo\Policies\ListingSeoSettingPolicy;

class ListingSeoServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'ListingSeo';
    protected string $nameLower = 'listingseo';

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
        Gate::policy(ListingSeoSetting::class, ListingSeoSettingPolicy::class);
    }
}
