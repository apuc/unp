<?php

namespace App\Http\Requests\Office\Bannersection;

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
		$rules = \App\Bannersection::$rules;

		$rules['sitesection_id'] .= ',' . $this->bannersection;

		return $rules;
	}
}
