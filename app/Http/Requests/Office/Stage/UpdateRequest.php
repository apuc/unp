<?php

namespace App\Http\Requests\Office\Stage;

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
		$rules = \App\Stage::$rules;

		$rules['name']			.= ',' . $this->stage;
		$rules['external_id']	.= ',' . $this->stage;

		return $rules;
	}
}
