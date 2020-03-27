<?php

namespace App\Http\Requests\Office\Customtype;

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
		$rules = \App\Customtype::$rules;

		$rules['name'] .= ',' . $this->customtype;
		$rules['slug'] .= ',' . $this->customtype;

		return $rules;
	}
}
