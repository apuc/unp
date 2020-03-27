<?php

namespace App\Entities;

class HelpquestionEntity extends AbstractEntity
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
					return route('office.helpquestion.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.helpquestion.search');

			case 'create':
				if (auth()->user()->can('create', \App\Helpquestion::class))
					return route('office.helpquestion.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldHelpsection()
	{
		return HelpsectionEntity::relation($this, $this->record->helpsection);
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
					return route('office.helpquestion.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldAnswer()
	{
		switch($this->property) {
			case 'type':
				return 'html';

			case 'value':
				return $this->record->answer;

			case 'control':
				return 'htmleditor';
		}
	}

	public function fieldIsEnabled()
	{
		switch($this->property) {
			case 'type':
				return 'boolean';

			case 'value':
				return $this->record->is_enabled;

			case 'control':
				return 'checkbox';
		}
	}

	// Counters

	public function fieldHelppicturesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->helppictures_count;
		}
	}
}
