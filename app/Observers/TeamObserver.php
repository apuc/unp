<?php

namespace App\Observers;

use App\Team;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class TeamObserver
{
	private $fields = [
		'logo',
	];

	public function saved(Team $team)
	{
		Upload::file($team, $this->fields);
	}

	public function deleted(Team $team)
	{
		Upload::destroy($team, $this->fields);
	}
}