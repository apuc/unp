<?php

namespace App\Http\Requests\Office\Bannercampaign;

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
		$rules = \App\Bannercampaign::$rules;

		$rules['name'] .= ',' . $this->bannercampaign;

		return $rules;
	}
}
