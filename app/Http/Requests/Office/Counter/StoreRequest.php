<?php

namespace App\Http\Requests\Office\Counter;

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
		$rules = \App\Counter::$rules;

		return $rules;
	}
}
