<?php

namespace App\Http\Requests\Office\Match;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\SluggableRequest;

class UpdateRequest extends FormRequest
{
	use SluggableRequest;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = \App\Match::$rules;

		$rules['name']			.= ',' . $this->match;
		$rules['external_id']	.= ',' . $this->match;

		return $rules;
	}
}
