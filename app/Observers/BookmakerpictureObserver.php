<?php

namespace App\Observers;

use App\Bookmakerpicture;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class BookmakerpictureObserver
{
	private $fields = [
		'picture',
	];

	public function saved(Bookmakerpicture $bookmakerpicture)
	{
		Upload::file($bookmakerpicture, $this->fields);
	}

	public function deleted(Bookmakerpicture $bookmakerpicture)
	{
		Upload::destroy($bookmakerpicture, $this->fields);
	}
}