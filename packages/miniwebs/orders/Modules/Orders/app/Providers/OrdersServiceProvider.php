<?php

namespace Modules\Orders\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Orders\Models\Order;
use Modules\Orders\Models\OrderSetting;
use Modules\Orders\Policies\OrderPolicy;
use Modules\Orders\Policies\OrderSettingPolicy;
use Modules\Orders\Services\OrderMinisitePageProvider;

class OrdersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        if ($this->app->bound(\Modules\ListingMinisite\Services\MinisiteExtensionRegistry::class)) {
            $registry = $this->app->make(\Modules\ListingMinisite\Services\MinisiteExtensionRegistry::class);
            $registry->registerPageDataProvider(new OrderMinisitePageProvider());
        }
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(OrderSetting::class, OrderSettingPolicy::class);
    }
}
