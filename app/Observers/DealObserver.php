<?php

namespace App\Observers;

use App\Deal;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class DealObserver
{
	private $fields = [
		'cover',
	];

	public function saved(Deal $deal)
	{
		Upload::file($deal, $this->fields);
	}

	public function deleted(Deal $deal)
	{
		Upload::destroy($deal, $this->fields);
	}
}