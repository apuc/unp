<?php

namespace App\Http\Requests\Office\Action;

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
		$rules = \App\Action::$rules;

		$rules['name'] 			.= ',' . $this->action;
		$rules['slug'] 			.= ',' . $this->action;

		return $rules;
	}
}
