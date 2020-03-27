<?php

namespace App\Http\Requests\Office\Noticetemplate;

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
		$rules = \App\Noticetemplate::$rules;

		$rules['action_id'] 	.= ',' . $this->noticetemplate;
		$rules['noticetype_id'] .= ',' . $this->noticetemplate;
		$rules['role_id'] 		.= ',' . $this->noticetemplate;

		return $rules;
	}
}
