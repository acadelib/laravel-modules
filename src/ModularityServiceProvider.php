<?php

namespace Acadelib\Modularity;

use Acadelib\Modularity\Console\Commands\DisableCommand;
use Acadelib\Modularity\Console\Commands\EnableCommand;
use Acadelib\Modularity\Console\Commands\ListCommand;
use Acadelib\Modularity\Console\Commands\MakeCommand;
use Acadelib\Modularity\Providers\BootstrapServiceProvider;
use Illuminate\Support\ServiceProvider;

class ModularityServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/modularity.php', 'modularity');

        $this->app->singleton('modularity', function ($app) {
            return new ModuleManager($app->make('files'));
        });

        $this->app->register(BootstrapServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/modularity.php' => config_path('modularity.php'),
            ], 'modularity-config');

            $this->commands([
                DisableCommand::class,
                EnableCommand::class,
                ListCommand::class,
                MakeCommand::class,
            ]);
        }
    }
}
