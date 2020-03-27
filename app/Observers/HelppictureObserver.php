<?php

namespace App\Observers;

use App\Helppicture;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class HelppictureObserver
{
	private $fields = [
		'picture',
	];

	public function saved(Helppicture $helppicture)
	{
		Upload::file($helppicture, $this->fields);
	}

	public function deleted(Helppicture $helppicture)
	{
		Upload::destroy($helppicture, $this->fields);
	}
}