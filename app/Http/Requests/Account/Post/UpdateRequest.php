<?php

namespace App\Http\Requests\Account\Post;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */

	public function rules()
	{
		return [
			'sport_id'		=> 'required|exists:sports,id',
			'poststatus_id'	=> 'required|exists:poststatuses,id',
			'name'			=> 'required|min:2|max:255|unique:posts,name,' . $this->post_id,
			'picture'		=> 'nullable|image',
			//'tag_id'		=> 'required|exists:tags,id',
		];
	}
}
