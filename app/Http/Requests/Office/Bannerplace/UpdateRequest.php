<?php

namespace App\Http\Requests\Office\Bannerplace;

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
		$rules = \App\Bannerplace::$rules;

		$rules['name'] .= ',' . $this->bannerplace;
		$rules['slug'] .= ',' . $this->bannerplace;

		return $rules;
	}
}
