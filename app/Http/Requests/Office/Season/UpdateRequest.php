<?php

namespace App\Http\Requests\Office\Season;

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
		$rules = \App\Season::$rules;

		$rules['name']			.= ',' . $this->season;
		$rules['external_id']	.= ',' . $this->season;

		return $rules;
	}
}
