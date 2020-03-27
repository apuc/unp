<?php

namespace App\Http\Requests\Office\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = \App\User::$rules;

		$rules['email'] .= ',' . $this->user;
		$rules['phone'] .= ',' . $this->user;
		$rules['login'] .= ',' . $this->user;

		$rules['password'] = 'nullable|' . $rules['password'];

		return $rules;
	}
}
