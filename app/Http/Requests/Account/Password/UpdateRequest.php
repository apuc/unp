<?php

namespace App\Http\Requests\Account\Password;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */

	public function rules()
	{
		switch ($this->isMethod('post')) {
			case true:
				return [
					'old_password'	=> 'required|old_password',
					'password'		=> 'min:6|confirmed',
				];

			default:
				return [];
		}
	}
}
