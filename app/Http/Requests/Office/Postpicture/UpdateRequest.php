<?php

namespace App\Http\Requests\Office\Postpicture;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\SluggableRequest;
use Str;

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
		$rules = \App\Postpicture::$rules;

		$rules['name'] .= ',' . $this->postpicture;

		$rules['picture'] = Str::replaceFirst('required', 'nullable', $rules['picture']);

		return $rules;
	}
}
