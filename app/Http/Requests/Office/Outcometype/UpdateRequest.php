<?php

namespace App\Http\Requests\Office\Outcometype;

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
		$rules = \App\Outcometype::$rules;

		$rules['name'] 			.= ',' . $this->outcometype;
		$rules['slug'] 			.= ',' . $this->outcometype;
		$rules['position'] 		.= ',' . $this->outcometype;
		$rules['external_id'] 	.= ',' . $this->outcometype;
		$rules['external_name'] .= ',' . $this->outcometype;

		return $rules;
	}
}
