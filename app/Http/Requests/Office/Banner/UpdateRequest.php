<?php

namespace App\Http\Requests\Office\Banner;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\SluggableRequest;
use Str;

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
		$rules = \App\Banner::$rules;

		$rules['bannerformat_id']	.= ',' . $this->banner;
		$rules['bannercampaign_id'] .= ',' . $this->banner;
		$rules['name'] 				.= ',' . $this->banner;

		$rules['picture'] = Str::replaceFirst('required', 'nullable', $rules['picture']);

		return $rules;
	}
}
