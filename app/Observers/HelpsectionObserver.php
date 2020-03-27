<?php

namespace App\Observers;

use App\Helpsection;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class HelpsectionObserver
{
	private $fields = [
		'icon',
	];

	public function saved(Helpsection $helpsection)
	{
		Upload::file($helpsection, $this->fields);
	}

	public function deleted(Helpsection $helpsection)
	{
		Upload::destroy($helpsection, $this->fields);
	}
}