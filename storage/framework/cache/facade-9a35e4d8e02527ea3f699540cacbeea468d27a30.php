<?php

namespace Facades\App\Queries\Site\Home;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Queries\Site\Home\PostsQuery
 */
class PostsQuery extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Queries\Site\Home\PostsQuery';
    }
}
