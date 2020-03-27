<?php

namespace App\Http\Requests\Office\Tag;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = \App\Tag::$rules;

		$rules['name'] .= ',' . $this->tag;

		return $rules;
	}
}
