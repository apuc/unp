<?php

namespace App\Observers;

use App\Briefpicture;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class BriefpictureObserver
{
	private $fields = [
		'picture',
	];

	public function saved(Briefpicture $briefpicture)
	{
		Upload::file($briefpicture, $this->fields);
	}

	public function deleted(Briefpicture $briefpicture)
	{
		Upload::destroy($briefpicture, $this->fields);
	}
}