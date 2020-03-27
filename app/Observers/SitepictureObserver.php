<?php

namespace App\Observers;

use App\Sitepicture;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class SitepictureObserver
{
	private $fields = [
		'picture',
	];

	public function saved(Sitepicture $sitepicture)
	{
		Upload::file($sitepicture, $this->fields);
	}

	public function deleted(Sitepicture $sitepicture)
	{
		Upload::destroy($sitepicture, $this->fields);
	}
}