<?php

namespace App\Http\Requests\Office\Posttournament;

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
		$rules = \App\Posttournament::$rules;

		$rules['tournament_id']	.= ',' . $this->posttournament;
		$rules['post_id']		.= ',' . $this->posttournament;

		return $rules;
	}
}
