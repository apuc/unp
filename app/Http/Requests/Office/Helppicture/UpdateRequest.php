<?php

namespace App\Http\Requests\Office\Helppicture;

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
		$rules = \App\Helppicture::$rules;

		$rules['name'] .= ',' . $this->helppicture;

		$rules['picture'] = Str::replaceFirst('required', 'nullable', $rules['picture']);

		return $rules;
	}
}
