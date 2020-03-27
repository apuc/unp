<?php

namespace App\Http\Requests\Office\Country;

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
		$rules = \App\Country::$rules;

		$rules['name'] 			.= ',' . $this->country;
		$rules['slug'] 			.= ',' . $this->country;
		$rules['external_id']	.= ',' . $this->country;
		$rules['external_name']	.= ',' . $this->country;

		return $rules;
	}
}
