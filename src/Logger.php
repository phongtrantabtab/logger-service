<?php

namespace Feng\Logger;

use Illuminate\Support\Facades\Log;

class Logger
{
    /**
     * Format backtrace info
     *
     * @param array $backtrace
     * @return string
     */
    private static function formatBacktrace(array $backtrace = []): string
    {
        $caller = $backtrace[1] ?? [];
        $file = isset($caller['file'])
            ? str_replace(base_path() . DIRECTORY_SEPARATOR, '', $caller['file'])
            : 'unknown file';
        $line = $caller['line'] ?? 'unknown line';

        return "<{$file} (Line:{$line})>";
    }

    /**
     * Write log to the specified channel and level.
     *
     * @param string $channel
     * @param string $level
     * @param string $message
     * @return void
     */
    private static function log(string $channel, string $level, string $message): void
    {
        $backtrace = self::formatBacktrace(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2));
        Log::channel($channel)->log($level, "{$backtrace} {$message}");
    }

    /**
     * Log a warning message.
     *
     * @param string $message
     * @return void
     */
    public static function warning(string $message = ''): void
    {
        self::log('warning', 'warning', $message);
    }

    /**
     * Log a fatal error message.
     *
     * @param string $message
     * @return void
     */
    public static function fatal(string $message = ''): void
    {
        self::log('fatal', 'critical', $message);
    }

    /**
     * Log an exception message.
     *
     * @param string $message
     * @return void
     */
    public static function exception(string $message = ''): void
    {
        self::log('exception', 'error', $message);
    }

    /**
     * Log a debug message.
     *
     * @param string $message
     * @return void
     */
    public static function debug(string $message = ''): void
    {
        self::log('debug', 'debug', $message);
    }

    /**
     * Log an informational message.
     *
     * @param string $message
     * @return void
     */
    public static function info(string $message = ''): void
    {
        self::log('info', 'info', $message);
    }

    /**
     * Log an activity message.
     *
     * @param string $message
     * @return void
     */
    public static function activity(string $message = ''): void
    {
        self::log('activity', 'info', $message);
    }
}
