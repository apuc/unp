<?php

namespace App\Http\Requests\Office\Posttag;

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
		$rules = \App\Posttag::$rules;

		$rules['tag_id']	.= ',' . $this->posttag;
		$rules['post_id']	.= ',' . $this->posttag;

		return $rules;
	}
}
