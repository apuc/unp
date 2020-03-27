<?php

namespace App\Http\Requests\Office\Actiongroup;

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
		$rules = \App\Actiongroup::$rules;

		$rules['name'] .= ',' . $this->actiongroup;
		$rules['slug'] .= ',' . $this->actiongroup;

		return $rules;
	}
}
