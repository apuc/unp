<?php

namespace App\Observers;

use App\Payment;

class PaymentObserver
{
	/**
	 *
	 *
	 */

	public function created(Payment $payment)
	{
		$this->updateUser($payment->user_id);
	}

	/**
	 *
	 *
	 *
	 */

	public function updated(Payment $payment)
	{
		// Если пользователь у платежа заменен, то пересчитать также и статистику старого пользователя
		if ($payment->isDirty('user_id'))
			$this->updateUser($payment->getOriginal('user_id'));

		$this->updateUser($payment->user_id);
	}

	/**
	 *
	 *
	 *
	 */

	public function deleted(Payment $payment)
	{
		$this->updateUser($payment->user_id);
	}

	/**
	 *
	 *
	 *
	 */

	private function updateUser($id)
	{
		$user = \App\User::findOrFail($id);
		$user->updateForecastsStat();
		$user->save();
	}
}