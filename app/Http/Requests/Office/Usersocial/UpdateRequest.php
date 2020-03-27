<?php

namespace App\Http\Requests\Office\Usersocial;

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
		$rules = \App\Usersocial::$rules;

		$rules['user_id']	.= ',' . $this->usersocial;
		$rules['social_id'] .= ',' . $this->usersocial;

		return $rules;
	}
}
