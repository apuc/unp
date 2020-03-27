<?php

namespace App\Http\Requests\Office\Brieftournament;

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
		$rules = \App\Brieftournament::$rules;

		$rules['tournament_id']	.= ',' . $this->brieftournament;
		$rules['brief_id']		.= ',' . $this->brieftournament;

		return $rules;
	}
}
