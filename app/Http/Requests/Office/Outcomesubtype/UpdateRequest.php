<?php

namespace App\Http\Requests\Office\Outcomesubtype;

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
		$rules = \App\Outcomesubtype::$rules;

		$rules['name'] 			.= ',' . $this->outcomesubtype;
		$rules['slug'] 			.= ',' . $this->outcomesubtype;
		$rules['position'] 		.= ',' . $this->outcomesubtype;
		$rules['external_id'] 	.= ',' . $this->outcomesubtype;
		$rules['external_name'] .= ',' . $this->outcomesubtype;

		return $rules;
	}
}
