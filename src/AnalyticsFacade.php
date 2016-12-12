<?php

namespace Nopaad\Analytics;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nopaad\Analytics\Analytics
 */
class AnalyticsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-analytics';
    }
}
