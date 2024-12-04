<?php

namespace phongtran\Logger\app\Http\Middleware;

use Closure;
use phongtran\Logger\App\Http\Traits\LogActivityTrait;
use phongtran\Logger\Logger;
use Illuminate\Http\Request;

/**
 * LogActivity Middleware
 *
 * @package phongtran\Logger\app\Http\Middleware
 * @copyright Copyright (c) 2024, jarvis.phongtran
 * @author phongtran <jarvis.phongtran@gmail.com>
 */
class LogActivity
{
    use LogActivityTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        $route = $request->route();
        $routeArray = $this->routeToArray($route);
        Logger::activity($this->formatRouteLog($routeArray));

        return $next($request);
    }
}
