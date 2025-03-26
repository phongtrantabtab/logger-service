<?php

namespace phongtrantabtab\Logger;

use Illuminate\Support\Facades\Log;
use phongtrantabtab\Logger\app\Services\Definitions\LoggerDef;

/**
 * Logger
 *
 * @package phongtran\Logger
 * @copyright Copyright (c) 2024, jarvis.phongtran
 * @author phongtran <phong.tran@tabtab.me>
 */
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
        $logMessage = $channel === LoggerDef::CHANNEL_ACTIVITY
            ? json_encode($message)
            : self::formatBacktrace(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)) . " {$message}";
        Log::channel($channel)->log($level, $logMessage);
    }

    /**
     * Log a warning message.
     *
     * @param string $message
     * @return void
     */
    public static function warning(string $message = ''): void
    {
        self::log(LoggerDef::CHANNEL_WARNING, LoggerDef::LEVEL_WARNING, $message);
    }

    /**
     * Log a fatal error message.
     *
     * @param string $message
     * @return void
     */
    public static function fatal(string $message = ''): void
    {
        self::log(LoggerDef::CHANNEL_FATAL, LoggerDef::LEVEL_CRITICAL, $message);
    }

    /**
     * Log an exception message.
     *
     * @param string $message
     * @return void
     */
    public static function exception(string $message = ''): void
    {
        self::log(LoggerDef::CHANNEL_EXCEPTION, LoggerDef::LEVEL_ERROR, $message);
    }

    /**
     * Log a debug message.
     *
     * @param string $message
     * @return void
     */
    public static function debug(string $message = ''): void
    {
        self::log(LoggerDef::CHANNEL_DEBUG, LoggerDef::LEVEL_DEBUG, $message);
    }

    /**
     * Log an informational message.
     *
     * @param string $message
     * @return void
     */
    public static function info(string $message = ''): void
    {
        self::log(LoggerDef::CHANNEL_INFO, LoggerDef::LEVEL_INFO, $message);
    }

    /**
     * Log an activity message.
     *
     * @param string $message
     * @return mixed
     */
    public static function activity(string $message = ''): mixed
    {
        return self::log(LoggerDef::CHANNEL_ACTIVITY, LoggerDef::LEVEL_INFO, $message);
    }

    /**
     * Log an sql query.
     *
     * @param string $query
     * @param float $executionTime
     * @return void
     */
    public static function sql(string $query = '', float $executionTime = 0): void
    {
        Log::channel(LoggerDef::CHANNEL_SQL)
            ->log(LoggerDef::LEVEL_INFO, "[ExecutionTime: {$executionTime}ms] {$query}");
    }
}
