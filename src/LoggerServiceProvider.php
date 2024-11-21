<?php

namespace Feng\Logger;

use Feng\Logger\App\Http\Middleware\LogActivity;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Router $router
     * @return void
     */
    public function boot(Router $router): void
    {
        $router->middlewareGroup('activity', [LogActivity::class]);
        if (Config::get('logger')) {
            Config::set('logging', array_replace_recursive(
                Config::get('logging'),
                Config::get('logger')
            ));
            QueryDebugger::setup();
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register Facade Logger
        $this->app->singleton('logger', function ($app) {
            return new Logger();
        });

        // Public config file logger.php
        $this->publishFiles();
    }

    /**
     * Publish files for Laravel Logger.
     *
     * @return void
     */
    private function publishFiles(): void
    {
        $publishTag = 'Logger';

        $this->publishes([
            __DIR__ . '/config/logger.php' => base_path('config/logger.php'),
        ], $publishTag);
    }
}
