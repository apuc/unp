<?php

namespace App\Http\Requests\Office\Brieftag;

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
		$rules = \App\Brieftag::$rules;

		$rules['tag_id']	.= ',' . $this->brieftag;
		$rules['brief_id']	.= ',' . $this->brieftag;

		return $rules;
	}
}
