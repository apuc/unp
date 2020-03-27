<?php

namespace App\Http\Requests\Office\Menuitem;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\SluggableRequest;

class StoreRequest extends FormRequest
{
	use SluggableRequest;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = \App\Menuitem::$rules;

		return $rules;
	}
}
