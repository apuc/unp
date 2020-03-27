<?php

namespace App\Http\Requests\Office\Briefstatus;

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
		$rules = \App\Briefstatus::$rules;

		$rules['name'] .= ',' . $this->briefstatus;
		$rules['slug'] .= ',' . $this->briefstatus;

		return $rules;
	}
}
