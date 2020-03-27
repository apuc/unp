<?php

namespace App\Http\Requests\Office\Poststatus;

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
		$rules = \App\Poststatus::$rules;

		$rules['name'] .= ',' . $this->poststatus;
		$rules['slug'] .= ',' . $this->poststatus;

		return $rules;
	}
}
