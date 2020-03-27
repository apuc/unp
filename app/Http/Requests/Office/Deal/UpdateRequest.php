<?php

namespace App\Http\Requests\Office\Deal;

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
		$rules = \App\Deal::$rules;

		$rules['name'] 	.= ',' . $this->deal;
		$rules['url'] 	.= ',' . $this->deal;

		return $rules;
	}
}
