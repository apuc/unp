<?php

namespace App\Observers;

use App\Banner;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class BannerObserver
{
	private $fields = [
		'picture',
	];

	public function saved(Banner $banner)
	{
		Upload::file($banner, $this->fields);
	}

	public function deleted(Banner $banner)
	{
		Upload::destroy($banner, $this->fields);
	}
}