<?php

namespace App\Http\Requests\Office\Legaldocument;

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
		$rules = \App\Legaldocument::$rules;

		$rules['name']		.= ',' . $this->legaldocument;
		$rules['slug']		.= ',' . $this->legaldocument;
		$rules['position']	.= ',' . $this->legaldocument;

		return $rules;
	}
}
