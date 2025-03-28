<?php

namespace Tabtab\Logger;

use Tabtab\Logger\App\Http\Middleware\LogActivity;
use Laravel\Lumen\Routing\Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

/**
 * Logger Service Provider
 *
 * @package phongtran\Logger
 * @copyright Copyright (c) 2024, jarvis.phongtran
 * @author phongtran <phong.tran@tabtab.me>
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
        $this->mergeConfigFrom(__DIR__ . '/config/logger.php', 'logging');
        $router->middlewareGroup('activity', [LogActivity::class]);
        $this->publishes([
            __DIR__ . '/config/logger.php' => config_path('logging.php'),
        ], 'config');
        if (config('logging.enable_query_debugger')) {
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
        $this->app->singleton('logger', function ($app) {
            return new Logger();
        });

        $this->registerEventListeners();
        $this->publishFiles();
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
//        $publishTag = 'logger';
//
//        $this->publishes([
//            __DIR__ . '/config/logger.php' => base_path('config/logger.php'),
//        ], $publishTag);
    }
}
