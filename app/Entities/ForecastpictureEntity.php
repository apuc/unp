<?php

namespace App\Entities;

class ForecastpictureEntity extends AbstractEntity
{
	public function key()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'id':
				return $this->record->id;

			case 'value':
				return $this->record->name;

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.forecastpicture.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.forecastpicture.search');

			case 'create':
				if (auth()->user()->can('create', \App\Forecastpicture::class))
					return route('office.forecastpicture.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldForecast()
	{
		return ForecastEntity::relation($this, $this->record->forecast);
	}

	// Fields

	public function fieldName()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->name;

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.forecastpicture.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldPicture()
	{
		switch($this->property) {
			case 'type':
				return 'picture';

			case 'value':
				return $this->record->picture;

			case 'required':
				return true;

			case 'control':
				return 'picture';
		}
	}
}
