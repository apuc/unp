<?php

namespace App\Http\Requests\Office\Forecast;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\SluggableRequest;

class UpdateRequest extends FormRequest
{
	use SluggableRequest;

	/**
	 *
	 *
	 */

	protected function prepareForValidation()
	{
		$outcome	= !is_null($this->outcome_id) ? \App\Outcome::find($this->outcome_id) : null;
		$forecast	= \App\Forecast::find($this->forecast);

		$this->request->set('outcometype_id',		!is_null($outcome) ? $outcome->outcometype_id		: $forecast->outcometype_id);
		$this->request->set('outcomescope_id',		!is_null($outcome) ? $outcome->outcomescope_id		: $forecast->outcomescope_id);
		$this->request->set('outcomesubtype_id',	!is_null($outcome) ? $outcome->outcomesubtype_id	: $forecast->outcomesubtype_id);
		$this->request->set('team_id',				!is_null($outcome) ? $outcome->team_id				: $forecast->team_id);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */

	public function rules()
	{
		$rules = \App\Forecast::$rules;

		$rules['outcome_id'] = 'nullable|' . $rules['outcome_id'];
		$rules['match_id']	.= ',' . $this->forecast;

		return $rules;
	}
}
