<?php

namespace App\Observers;

use App\Forecast;

class ForecastObserver
{
	public function created(Forecast $forecast)
	{
		$this->updateUser($forecast->user_id);
	}

	public function updated(Forecast $forecast)
	{
		// Если пользователь у прогноза заменен, то пересчитать также и статистику старого пользователя
		if ($forecast->isDirty('user_id')) 
			$this->updateUser($forecast->getOriginal('user_id'));
		
		$this->updateUser($forecast->user_id);
	}

	public function deleted(Forecast $forecast)
	{
		$this->updateUser($forecast->user_id);
	}

	private function updateUser($id)
	{
		$user = \App\User::findOrFail($id);
		$user->updateForecastsStat();
		$user->save();
	}
}