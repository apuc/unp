<?php

namespace App\Observers;

use App\Tournament;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class TournamentObserver
{
	private $fields = [
		'logo',
	];

	public function saved(Tournament $tournament)
	{
		Upload::file($tournament, $this->fields);
	}

	public function deleted(Tournament $tournament)
	{
		Upload::destroy($tournament, $this->fields);
	}
}