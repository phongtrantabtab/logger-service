<?php

namespace phongtran\Logger\facades;

use Illuminate\Support\Facades\Facade;

class Logger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'logger';
    }
}
