<?php

namespace Acadelib\Modularity\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        foreach ($this->app->make('modularity')->all() as $module) {
            if ($module->isEnabled() && $module->isAutoloaded()) {
                $this->loadRoutesFrom($module->getPath().'/Routes/web.php');
                $this->loadMigrationsFrom($module->getPath().'/Database/Migrations');
                $this->loadTranslationsFrom($module->getPath().'/Resources/Lang', $module->getName());
                $this->loadViewsFrom($module->getPath().'/Resources/Views', $module->getName());
            }
        }
    }
}
