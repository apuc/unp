<?php

namespace App\Http\Requests\Office\Team;

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
		$rules = \App\Team::$rules;

		$rules['name']			.= ',' . $this->team;
		$rules['external_id']	.= ',' . $this->team;

		return $rules;
	}
}
