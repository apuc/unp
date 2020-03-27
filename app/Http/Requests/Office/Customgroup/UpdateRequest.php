<?php

namespace App\Http\Requests\Office\Customgroup;

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
		$rules = \App\Customgroup::$rules;

		$rules['name'] .= ',' . $this->customgroup;
		$rules['slug'] .= ',' . $this->customgroup;

		return $rules;
	}
}
