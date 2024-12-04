<?php

namespace phongtran\Logger\facades;

use Illuminate\Support\Facades\Facade;

/**
 * Logger Facade
 *
 * @package phongtran\Logger\app\Services\Definitions
 * @copyright Copyright (c) 2024, jarvis.phongtran
 * @author phongtran <jarvis.phongtran@gmail.com>
 */
class Logger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'logger';
    }
}
