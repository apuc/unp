<?php

namespace Facades\App\Queries\Middleware;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Queries\Middleware\MenuQuery
 */
class MenuQuery extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Queries\Middleware\MenuQuery';
    }
}
