<?php

namespace App\Http\Requests\Office\Benefit;

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
		$rules = \App\Benefit::$rules;

		$rules['name'] 		.= ',' . $this->benefit;
		$rules['slug'] 		.= ',' . $this->benefit;
		$rules['url'] 		.= ',' . $this->benefit;
		$rules['position'] 	.= ',' . $this->benefit;

		return $rules;
	}
}
