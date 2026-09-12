<?php

namespace Modules\Properties\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Properties\Models\Property;
use Modules\Properties\Models\PropertyType;
use Modules\Properties\Observers\PropertyTypeObserver;
use Modules\Properties\Policies\PropertyPolicy;
use Modules\Properties\Policies\PropertyTypePolicy;
use Modules\Properties\Services\PropertyMinisiteProvider;

class PropertiesServiceProvider extends ServiceProvider
{
    protected string $name = 'Properties';

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        if ($this->app->bound(\Modules\ListingMinisite\Services\MinisiteExtensionRegistry::class)) {
            $registry = $this->app->make(\Modules\ListingMinisite\Services\MinisiteExtensionRegistry::class);
            $registry->registerSectionProvider(new PropertyMinisiteProvider());
        }
    }

    public function boot(): void
    {
        $this->registerPolicies();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    protected function registerPolicies(): void
    {
        Gate::policy(Property::class, PropertyPolicy::class);
        Gate::policy(PropertyType::class, PropertyTypePolicy::class);

        PropertyType::observe(PropertyTypeObserver::class);
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/views/lang', $this->name);
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path($this->name . '/config.php'),
        ], 'config');
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', $this->name);
    }
}
