<?php

namespace App\Http\Requests\Office\Forecast;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\SluggableRequest;

class StoreRequest extends FormRequest
{
	use SluggableRequest;

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
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */

	public function rules()
	{
		$rules = \App\Forecast::$rules;

		$rules['outcome_id'] = 'required|' . $rules['outcome_id'];

		return $rules;
	}
}
