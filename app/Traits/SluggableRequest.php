<?php

namespace App\Traits;

trait SluggableRequest
{
	protected function prepareForValidation()
	{
        $this->merge(['slug' => str_slug($this->slug ?? $this->name)]);
	}
}
