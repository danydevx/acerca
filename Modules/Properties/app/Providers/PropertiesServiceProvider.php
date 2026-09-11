<?php

namespace Modules\Properties\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Properties\Console\Commands\SetupBaseFields;
use Modules\Properties\Models\Property;
use Modules\Properties\Models\PropertyType;
use Modules\Properties\Observers\PropertyTypeObserver;
use Modules\Properties\Policies\PropertyPolicy;
use Modules\Properties\Policies\PropertyTypePolicy;

class PropertiesServiceProvider extends ServiceProvider
{
    protected string $name = 'Properties';

    public function boot(): void
    {
        $this->registerPolicies();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->commands([SetupBaseFields::class]);
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
