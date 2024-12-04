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
            // Extract the table name (this is a basic approach and might need adjustment based on query structure)
            $table = '';
            if (
                preg_match('/from\s+([^\s]+)/i', $sql->sql, $matches)
                || preg_match('/update\s+([^\s]+)/i', $sql->sql, $matches)
                || preg_match('/into\s+([^\s]+)/i', $sql->sql, $matches)
            ) {
                $table = self::removeSemicolon($matches[1]);
            }
            if (!in_array($table, self::getIgnoredTables())) {
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
            }
        });
    }

    /**
     * Remove semicolon
     *
     * @param string $string
     * @return string
     */
    private static function removeSemicolon(string $string): string
    {
        return preg_replace('/["`\';]/', '', $string);
    }

    /**
     * Get Ignored Tables
     *
     * @return array
     */
    private static function getIgnoredTables(): array
    {
        $logTables = [
            config('logger.table'),
            config('logger.query_table')
        ];

        $ignoredTables = array_filter(array_map(
                'trim',
                explode(',', config('logger.ignored_tables', ''))
            )
        );

        return array_merge($logTables, $ignoredTables);
    }
}
