<?php

namespace phongtran\Logger;

use phongtran\Logger\App\Http\Middleware\LogActivity;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * Logger Service Provider
 *
 * @package phongtran\Logger
 * @copyright Copyright (c) 2024, jarvis.phongtran
 * @author phongtran <jarvis.phongtran@gmail.com>
 */
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
            Config::set('logging', array_merge(
                Config::get('logging'),
                Config::get('logger')
            ));
        }
        if (config('logger.enable_query_debugger')) {
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
        if (file_exists(config_path('logger.php'))) {
            $this->mergeConfigFrom(config_path('logger.php'), 'Logger');
        } else {
            $this->mergeConfigFrom(__DIR__ . '/config/logger.php', 'Logger');
        }

        $this->app->singleton('logger', function ($app) {
            return new Logger();
        });

        $this->registerEventListeners();
        $this->publishFiles();
    }

    /**
     * Get the list of listeners and events.
     *
     * @return array
     */
    private function getListeners(): array
    {
        return $this->listeners;
    }

    /**
     * Register the list of listeners and events.
     *
     * @return void
     */
    private function registerEventListeners(): void
    {
    }

    /**
     * Publish files for Laravel Logger.
     *
     * @return void
     */
    private function publishFiles(): void
    {
        $publishTag = 'logger';

        $this->publishes([
            __DIR__ . '/config/logger.php' => base_path('config/logger.php'),
        ], $publishTag);
    }
}
