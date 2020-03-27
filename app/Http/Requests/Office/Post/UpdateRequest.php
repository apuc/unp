<?php

namespace App\Http\Requests\Office\Post;

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
		$rules = \App\Post::$rules;

		$rules['name'] .= ',' . $this->post;

		return $rules;
	}
}
