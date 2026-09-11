<?php

namespace Modules\ListingSeo\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\ListingSeo\Models\ListingSeoSetting;
use Modules\ListingSeo\Policies\ListingSeoSettingPolicy;

class ListingSeoServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(ListingSeoSetting::class, ListingSeoSettingPolicy::class);
    }
}
