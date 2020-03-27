<?php

namespace App\Observers;

use App\Postcomment;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class PostcommentObserver
{
	public function created(Postcomment $postcomment)
	{
		$this->updateUser($postcomment->user_id);
	}

	public function updated(Postcomment $postcomment)
	{
		// Если пользователь у комментария к посту заменен, то пересчитать также и статистику старого пользователя
		if ($postcomment->isDirty('user_id')) {
			$this->updateUser($postcomment->getOriginal('user_id'));
			$this->updateUser($postcomment->user_id);
		}
	}

	public function deleted(Postcomment $postcomment)
	{
		$this->updateUser($postcomment->user_id);
	}

	private function updateUser($id)
	{
		$user = \App\User::findOrFail($id);
		$user->updateCommentsStat();
		$user->save();
	}
}