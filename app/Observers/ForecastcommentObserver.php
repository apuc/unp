<?php

namespace App\Observers;

use App\Forecastcomment;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class ForecastcommentObserver
{
	public function created(Forecastcomment $forecastcomment)
	{
		$this->updateUser($forecastcomment->user_id);
	}

	public function updated(Forecastcomment $forecastcomment)
	{
		// Если пользователь у комментария к прогнозу заменен, то пересчитать также и статистику старого пользователя
		if ($forecastcomment->isDirty('user_id')) {
			$this->updateUser($forecastcomment->getOriginal('user_id'));
			$this->updateUser($forecastcomment->user_id);
		}
	}

	public function deleted(Forecastcomment $forecastcomment)
	{
		$this->updateUser($forecastcomment->user_id);
	}

	private function updateUser($id)
	{
		$user = \App\User::findOrFail($id);
		$user->updateCommentsStat();
		$user->save();
	}
}