<?php

namespace App\Http\Requests\Account\Forecast;

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
			'sport_id'			=> 'required|exists:sports,id',
			'outcome_id'		=> 'required|exists:outcomes,id',
			'bookmaker_id'		=> 'required|exists:bookmakers,id',
			'match_id'			=> 'required|exists:matches,id|unique_with:forecasts,user_id,' . $this->forecast_id,
			'forecaststatus_id'	=> 'required|exists:forecaststatuses,id',
			'rate'				=> 'required|numeric',
			'bet'				=> 'required|integer',
			'description'		=> 'required',
		];
	}
}
