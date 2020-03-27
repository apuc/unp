<?php

namespace App\Http\Requests\Office\Bookmaker;

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
		$rules = \App\Bookmaker::$rules;

		$rules['name'] 			.= ',' . $this->bookmaker;
		$rules['slug'] 			.= ',' . $this->bookmaker;
		$rules['site'] 			.= ',' . $this->bookmaker;
		$rules['phone'] 		.= ',' . $this->bookmaker;
		$rules['email'] 		.= ',' . $this->bookmaker;
		$rules['address']		.= ',' . $this->bookmaker;
		$rules['position']		.= ',' . $this->bookmaker;
		$rules['external_id']	.= ',' . $this->bookmaker;

		return $rules;
	}
}
