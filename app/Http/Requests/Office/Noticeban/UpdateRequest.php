<?php

namespace App\Http\Requests\Office\Noticeban;

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
		$rules = \App\Noticeban::$rules;

		$rules['noticetype_id'] .= ',' . $this->noticeban;
		$rules['action_id'] 	.= ',' . $this->noticeban;
		$rules['user_id'] 		.= ',' . $this->noticeban;

		return $rules;
	}
}
