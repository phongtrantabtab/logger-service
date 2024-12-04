<?php

namespace phongtran\Logger;

use DateTime;
use Illuminate\Support\Facades\DB;

/**
 * Query Debugger
 *
 * @package phongtran\Logger
 * @copyright Copyright (c) 2024, jarvis.phongtran
 * @author phongtran <jarvis.phongtran@gmail.com>
 */
class QueryDebugger
{
    /**
     * Set up the debugger
     *
     * @return void
     */
    public static function setup(): void
    {
        DB::listen(function ($sql) {
            foreach ($sql->bindings as $index => $binding) {
                if ($binding instanceof DateTime) {
                    $sql->bindings[$index] = $binding->format('\'Y-m-d H:i:s\'');
                } else {
                    if (is_string($binding)) {
                        $sql->bindings[$index] = "'$binding'";
                    }
                }
            }
            $query = str_replace(['%', '?'], ['%%', '%s'], $sql->sql);
            $query = vsprintf($query, $sql->bindings);
            $executionTime = $sql->time;
            Logger::sql($query, $executionTime);
        });
    }
}
