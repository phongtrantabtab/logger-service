<?php

namespace Tabtab\Logger\app\Http\Middleware;

use Illuminate\Http\Request;
use phongtrantabtab\Logger\Logger;
use phongtrantabtab\Logger\App\Http\Traits\LogActivityTrait;
use Closure;

/**
 * LogActivity Middleware
 *
 * @package phongtran\Logger\app\Http\Middleware
 * @copyright Copyright (c) 2024, jarvis.phongtran
 * @author phongtran <phong.tran@tabtab.me>
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
