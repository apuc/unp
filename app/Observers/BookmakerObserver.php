<?php

namespace App\Observers;

use App\Bookmaker;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class BookmakerObserver
{
	private $fields = [
		'logo',
		'cover',
	];

	public function saved(Bookmaker $bookmaker)
	{
		Upload::file($bookmaker, $this->fields);
	}

	public function deleted(Bookmaker $bookmaker)
	{
		Upload::destroy($bookmaker, $this->fields);
	}
}