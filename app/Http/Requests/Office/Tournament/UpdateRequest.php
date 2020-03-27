<?php

namespace App\Http\Requests\Office\Tournament;

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
		$rules = \App\Tournament::$rules;

		$rules['name']			.= ',' . $this->tournament;
		$rules['external_id']	.= ',' . $this->tournament;
		$rules['position']		.= ',' . $this->tournament;

		return $rules;
	}
}
