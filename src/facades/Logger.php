<?php

namespace phongtrantabtab\Logger\facades;

use Illuminate\Support\Facades\Facade;

/**
 * Logger Facade
 *
 * @package phongtran\Logger\app\Services\Definitions
 * @copyright Copyright (c) 2024, jarvis.phongtran
 * @author phongtran <phong.tran@tabtab.me>
 */
class Logger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'logger';
    }
}
