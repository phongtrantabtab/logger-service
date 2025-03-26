<?php

namespace phongtrantabtab\Logger;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;

/**
 * Log Formatter
 *
 * @package phongtran\Logger
 * @copyright Copyright (c) 2024, jarvis.phongtran
 * @author phongtran <phong.tran@tabtab.me>
 */
class LogFormatter
{
    /**
     * Invoker
     *
     * @param \Illuminate\Log\Logger $logger
     * @param string $logFormat
     * @param string $dateFormat
     * @return void
     */
    public function __invoke(\Illuminate\Log\Logger $logger, string $logFormat, string $dateFormat): void
    {
        $formatter = new LineFormatter($logFormat, $dateFormat, true, true);
        $introspection = new IntrospectionProcessor(Logger::DEBUG, ['Illuminate\\']);
        $web = new WebProcessor();

        /** @var Logger $logger */
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($formatter);
            $handler->pushProcessor($introspection);
            $handler->pushProcessor($web);
        }
    }
}
