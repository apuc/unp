<?php

namespace App\Http\Requests\Office\Outcome;

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
		$rules = \App\Outcome::$rules;

		$rules['external_id'] .= ',' . $this->outcome;

		return $rules;
	}
}
