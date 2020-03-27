<?php

namespace App\Observers;

use App\Forecastpicture;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class ForecastpictureObserver
{
	private $fields = [
		'picture',
	];

	public function saved(Forecastpicture $forecastpicture)
	{
		Upload::file($forecastpicture, $this->fields);
	}

	public function deleted(Forecastpicture $forecastpicture)
	{
		Upload::destroy($forecastpicture, $this->fields);
	}
}