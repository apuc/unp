<?php

namespace App\Http\Requests\Office\Sport;

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
		$rules = \App\Sport::$rules;

		$rules['name'] 			.= ',' . $this->sport;
		$rules['slug'] 			.= ',' . $this->sport;
		$rules['external_id'] 	.= ',' . $this->sport;
		$rules['external_name'] .= ',' . $this->sport;
		$rules['position']		.= ',' . $this->sport;

		return $rules;
	}
}
