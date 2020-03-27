<?php

namespace App\Observers;

use App\Sitetext;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class SitetextObserver
{
	private $fields = [
		'picture',
	];

	public function saved(Sitetext $sitetext)
	{
		Upload::file($sitetext, $this->fields);
	}

	public function deleted(Sitetext $sitetext)
	{
		Upload::destroy($sitetext, $this->fields);
	}
}