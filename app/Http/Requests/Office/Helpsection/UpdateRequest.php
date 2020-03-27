<?php

namespace App\Http\Requests\Office\Helpsection;

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
		$rules = \App\Helpsection::$rules;

		$rules['name'] .= ',' . $this->helpsection;
		$rules['slug'] .= ',' . $this->helpsection;

		return $rules;
	}
}
