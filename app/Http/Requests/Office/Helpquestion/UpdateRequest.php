<?php

namespace App\Http\Requests\Office\Helpquestion;

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
		$rules = \App\Helpquestion::$rules;

		$rules['name'] .= ',' . $this->helpquestion;

		return $rules;
	}
}
