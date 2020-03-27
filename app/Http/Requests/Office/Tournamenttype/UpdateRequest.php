<?php

namespace App\Http\Requests\Office\Tournamenttype;

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
		$rules = \App\Tournamenttype::$rules;

		$rules['name'] .= ',' . $this->tournamenttype;

		return $rules;
	}
}
