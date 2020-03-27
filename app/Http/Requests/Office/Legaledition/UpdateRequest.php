<?php

namespace App\Http\Requests\Office\Legaledition;

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
		$rules = \App\Legaledition::$rules;

		$rules['issued_at'] .= ',' . $this->legaledition;

		return $rules;
	}
}