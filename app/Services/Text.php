<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

/**
 * 
 * 
 */
class Text
{
    public function get($section, $text)
    {
    	if (filled($document = $section->sitetexts->firstWhere('slug', $text)))
	    	return $document;
		else
			return null;
    }
}
