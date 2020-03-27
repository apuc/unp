<?php

namespace App\Observers;

use App\Postpicture;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class PostpictureObserver
{
	private $fields = [
		'picture',
	];

	public function saved(Postpicture $postpicture)
	{
		Upload::file($postpicture, $this->fields);
	}

	public function deleted(Postpicture $postpicture)
	{
		Upload::destroy($postpicture, $this->fields);
	}
}