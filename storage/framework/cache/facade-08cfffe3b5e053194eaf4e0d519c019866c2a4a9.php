<?php

namespace Facades\App\Queries\Site\Home;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Queries\Site\Home\TournamentsQuery
 */
class TournamentsQuery extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Queries\Site\Home\TournamentsQuery';
    }
}
