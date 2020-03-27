<?php

namespace App\Http\Requests\Office\Customparam;

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
		$rules = \App\Customparam::$rules;

		$rules['name'] .= ',' . $this->customparam;
		$rules['slug'] .= ',' . $this->customparam;

		return $rules;
	}
}
