<?php

namespace App\Http\Requests\Office\Participant;

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
		$rules = \App\Participant::$rules;

		$rules['match_id']		.= ',' . $this->participant;
		$rules['position']		.= ',' . $this->participant;
		$rules['external_id']	.= ',' . $this->participant;

		return $rules;
	}
}
