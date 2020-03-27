<?php

namespace App\Http\Requests\Office\Forecaststatus;

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
		$rules = \App\Forecaststatus::$rules;

		$rules['name'] .= ',' . $this->forecaststatus;
		$rules['slug'] .= ',' . $this->forecaststatus;

		return $rules;
	}
}
