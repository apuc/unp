<?php

namespace App\Http\Requests\Account\Personal;

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
					'login'	=> 'required|min:2|max:255|login|unique:users,login,' . Auth::user()->id,
					'email'	=> 'required|email|min:3|max:255|unique:users,email,' . Auth::user()->id,
					'name'	=> 'nullable|min:2|max:255',
					'about'	=> 'nullable|max:1000',
					'phone'	=> 'nullable|mobile_number|unique:users,phone',
				];

			default:
				return [];
		}
	}
}
