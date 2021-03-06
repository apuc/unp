<?php

namespace App\Http\Requests\Account\Brief;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */

	public function rules()
	{
		return [
			'sport_id'			=> 'required|exists:sports,id',
			'briefstatus_id'	=> 'required|exists:briefstatuses,id',
			'name'				=> 'required|min:2|max:255|unique:briefs,name',
			'picture'			=> 'required|image',
			//'tag_id'			=> 'required|exists:tags,id',
		];
	}
}
