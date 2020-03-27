<?php

namespace App\Queries\Middleware;

use App\Queries\Query;

class MenuQuery extends Query
{
	public function run()
	{
		return \App\Menusection::query()
    		->with([
    			'menuitems' => function ($query) {
    				$query
    					->where('is_enabled', true)
    					->sortBy('position');
    			},
    		])			
    		->where('is_enabled', true)
    		->orderBy('position')
    		->get();
	}
}
