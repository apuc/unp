<?php

namespace App\Http\Requests\Office\Dealtype;

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
		$rules = \App\Dealtype::$rules;

		$rules['name'] .= ',' . $this->dealtype;
		$rules['slug'] .= ',' . $this->dealtype;

		return $rules;
	}
}
