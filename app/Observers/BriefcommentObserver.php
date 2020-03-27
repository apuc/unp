<?php

namespace App\Observers;

use App\Briefcomment;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class BriefcommentObserver
{
	public function created(Briefcomment $briefcomment)
	{
		$this->updateUser($briefcomment->user_id);
	}

	public function updated(Briefcomment $briefcomment)
	{
		// Если пользователь у комментария к статье заменен, то пересчитать также и статистику старого пользователя
		if ($briefcomment->isDirty('user_id')) {
			$this->updateUser($briefcomment->getOriginal('user_id'));
			$this->updateUser($briefcomment->user_id);
		}
	}

	public function deleted(Briefcomment $briefcomment)
	{
		$this->updateUser($briefcomment->user_id);
	}

	private function updateUser($id)
	{
		$user = \App\User::findOrFail($id);
		$user->updateCommentsStat();
		$user->save();
	}
}