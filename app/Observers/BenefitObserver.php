<?php

namespace App\Observers;

use App\Benefit;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class BenefitObserver
{
	private $fields = [
		'icon',
	];

	public function saved(Benefit $benefit)
	{
		Upload::file($benefit, $this->fields);
	}

	public function deleted(Benefit $benefit)
	{
		Upload::destroy($benefit, $this->fields);
	}
}