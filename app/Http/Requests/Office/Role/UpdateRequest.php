<?php

namespace App\Http\Requests\Office\Role;

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
		$rules = \App\Role::$rules;

		$rules['name'] .= ',' . $this->role;
		$rules['slug'] .= ',' . $this->role;

		return $rules;
	}
}
