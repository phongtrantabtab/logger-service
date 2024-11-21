<?php

namespace PhongTran\Logger\app\Http\Middleware;

use Closure;
use PhongTran\Logger\App\Http\Traits\LogActivityTrait;
use PhongTran\Logger\Logger;
use Illuminate\Http\Request;

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
        $routeJson = json_encode($routeArray);
        Logger::activity($routeJson);

        return $next($request);
    }
}
