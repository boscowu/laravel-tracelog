<?php

namespace boscowu\TraceLog\Facades;

use Illuminate\Support\Facades\Facade;

class TraceLog extends Facade
{
    /**
     * @method static void log($level, string $message, array $context = [])
     * @method static void setLogChannel($channel)
     * @see \ZM\TraceLog\TraceLog
     */


    /**
     * Return the facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'TraceLog';
    }
}

