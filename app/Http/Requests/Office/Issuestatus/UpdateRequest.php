<?php

namespace App\Http\Requests\Office\Issuestatus;

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
		$rules = \App\Issuestatus::$rules;

		$rules['name'] .= ',' . $this->issuestatus;
		$rules['slug'] .= ',' . $this->issuestatus;

		return $rules;
	}
}
