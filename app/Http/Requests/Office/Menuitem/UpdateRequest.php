<?php

namespace App\Http\Requests\Office\Menuitem;

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
		$rules = \App\Menuitem::$rules;

		$rules['name'] 		.= ',' . $this->menuitem;
		$rules['url'] 		.= ',' . $this->menuitem;
		$rules['position'] 	.= ',' . $this->menuitem;

		return $rules;
	}
}
