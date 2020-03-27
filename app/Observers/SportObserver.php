<?php

namespace App\Observers;

use App\Sport;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class SportObserver
{
	private $fields = [
		'icon',
	];

	public function saved(Sport $sport)
	{
		Upload::file($sport, $this->fields);
	}

	public function deleted(Sport $sport)
	{
		Upload::destroy($sport, $this->fields);
	}
}