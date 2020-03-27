<?php

namespace App\Http\Requests\Office\Bannerformat;

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
		$rules = \App\Bannerformat::$rules;

		$rules['name'] 		.= ',' . $this->bannerformat;
		$rules['slug'] 		.= ',' . $this->bannerformat;
		$rules['width'] 	.= ',' . $this->bannerformat;
		$rules['height'] 	.= ',' . $this->bannerformat;

		return $rules;
	}
}
