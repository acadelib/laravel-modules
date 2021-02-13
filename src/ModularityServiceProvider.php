<?php

namespace Acadelib\Modularity;

use Acadelib\Modularity\Console\Commands\ListCommand;
use Acadelib\Modularity\Console\Commands\MakeCommand;
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
                ListCommand::class,
                MakeCommand::class,
            ]);
        }
    }
}
