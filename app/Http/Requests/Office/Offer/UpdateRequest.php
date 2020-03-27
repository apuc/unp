<?php

namespace App\Http\Requests\Office\Offer;

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
		$rules = \App\Offer::$rules;

		$rules['outcome_id']	.= ',' . $this->offer;
		$rules['external_id']	.= ',' . $this->offer;

		return $rules;
	}
}
