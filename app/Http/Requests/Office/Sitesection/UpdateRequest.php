<?php

namespace App\Http\Requests\Office\Sitesection;

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
		$rules = \App\Sitesection::$rules;

		$rules['name'] .= ',' . $this->sitesection;
		$rules['slug'] .= ',' . $this->sitesection;

		return $rules;
	}
}
