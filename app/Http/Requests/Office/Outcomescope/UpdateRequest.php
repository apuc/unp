<?php

namespace App\Http\Requests\Office\Outcomescope;

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
		$rules = \App\Outcomescope::$rules;

		$rules['name'] 			.= ',' . $this->outcomescope;
		$rules['slug'] 			.= ',' . $this->outcomescope;
		$rules['position'] 		.= ',' . $this->outcomescope;
		$rules['external_id'] 	.= ',' . $this->outcomescope;
		$rules['external_name'] .= ',' . $this->outcomescope;

		return $rules;
	}
}
