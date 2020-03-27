<?php

namespace App\Http\Requests\Account\Forecast;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreRequest extends FormRequest
{
	/**
	 *
	 *
	 */

	protected function prepareForValidation()
	{
		if (null !== $this->outcome_id) {
			$outcome = \App\Outcome::find($this->outcome_id);

			$this->request->set('outcometype_id',		$outcome->outcometype_id);
			$this->request->set('outcomescope_id',		$outcome->outcomescope_id);
			$this->request->set('outcomesubtype_id',	$outcome->outcomesubtype_id);
			$this->request->set('team_id',				$outcome->team_id);
		}

		$this->request->set('user_id', Auth::user()->id);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */

	public function rules()
	{
		return [
			'sport_id'			=> 'required|exists:sports,id',
			'tournament_id'		=> 'required|exists:tournaments,id',
			'outcome_id'		=> 'required|exists:outcomes,id',
			'outcometype_id'	=> 'required|exists:outcometypes,id',
			'bookmaker_id'		=> 'required|exists:bookmakers,id',
			'match_id'			=> 'required|match_time|unique_with:forecasts,outcometype_id,user_id',
			'rate'				=> 'required|numeric',
			'bet'				=> 'required|integer|in:50,100,250,500,1000|forecast_balance',
		];
	}
}
