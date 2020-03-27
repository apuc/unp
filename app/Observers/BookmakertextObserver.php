<?php

namespace App\Observers;

use App\Bookmakertext;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class BookmakertextObserver
{
	private $fields = [
		'picture',
	];

	public function saved(Bookmakertext $bookmakertext)
	{
		Upload::file($bookmakertext, $this->fields);
	}

	public function deleted(Bookmakertext $bookmakertext)
	{
		Upload::destroy($bookmakertext, $this->fields);
	}
}