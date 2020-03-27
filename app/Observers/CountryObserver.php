<?php

namespace App\Observers;

use App\Country;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class CountryObserver
{
	private $fields = [
		'flag',
	];

	public function saved(Country $country)
	{
		Upload::file($country, $this->fields);
	}

	public function deleted(Country $country)
	{
		Upload::destroy($country, $this->fields);
	}
}