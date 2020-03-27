<?php

namespace App\Observers;

use App\Brief;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class BriefObserver
{
	private $fields = [
		'picture',
	];

	public function created(Brief $brief)
	{
		$this->updateUser($brief->user_id);
	}

	public function updated(Brief $brief)
	{
		// Если пользователь у поста заменен, то пересчитать также и статистику старого пользователя
		if ($brief->isDirty('user_id')) {
			$this->updateUser($brief->getOriginal('user_id'), true);
			$this->updateUser($brief->user_id, true);
		}
	}

	public function saved(Brief $brief)
	{
		Upload::file($brief, $this->fields);
	}

	public function deleted(Brief $brief)
	{
		Upload::destroy($brief, $this->fields);

		$this->updateUser($brief->user_id, true);
	}

	private function updateUser($id, $isUpdateComments = false)
	{
		$user = \App\User::findOrFail($id);
		$user->updateBriefsStat();

		if ($isUpdateComments)
			$user->updateCommentsStat();

		$user->save();
	}
}