<?php

namespace App\Http\Requests\Office\Commentstatus;

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
		$rules = \App\Commentstatus::$rules;

		$rules['name'] .= ',' . $this->commentstatus;
		$rules['slug'] .= ',' . $this->commentstatus;

		return $rules;
	}
}
