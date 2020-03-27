<?php

namespace App\Http\Requests\Office\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = \App\User::$rules;

		$rules['password'] = 'required|' . $rules['password'];

		return $rules;
	}
}
