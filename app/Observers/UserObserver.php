<?php

namespace App\Observers;

use App\User;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class UserObserver
{
	private $fields = [
		'avatar',
	];

	public function saved(User $user)
	{
		Upload::file($user, $this->fields);
	}

	public function deleted(User $user)
	{
		Upload::destroy($user, $this->fields);
	}
}