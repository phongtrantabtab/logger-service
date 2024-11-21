<?php

namespace Feng\Logger\app\Http\Traits;

trait LogActivityTrait
{
    /**
     * Get route's information from request
     *
     * @param $route
     * @return array
     */
    private function routeToArray($route): array
    {
        return [
            'uri' => $route->uri(),
            'methods' => $route->methods(),
            'routeName' => $route->getName(),
            'action' => $route->getAction(),
            'parameters' => $route->parameters(),
        ];
    }
}
