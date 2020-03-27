<?php

namespace App\Http\Requests\Office\Social;

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
		$rules = \App\Social::$rules;

		$rules['name'] 		.= ',' . $this->social;
		$rules['slug'] 		.= ',' . $this->social;
		$rules['site'] 		.= ',' . $this->social;
		$rules['community'] .= ',' . $this->social;
		$rules['icon'] 		.= ',' . $this->social;

		return $rules;
	}
}
