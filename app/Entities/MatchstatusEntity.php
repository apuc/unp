<?php

namespace App\Entities;

class MatchstatusEntity extends AbstractEntity
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
					return route('office.matchstatus.show', $this->record->id);
				else
					return null;

			case 'foreground':
				return $this->record->color_fg;

			case 'background':
				return $this->record->color_bg;

			case 'search':
				return route('office.matchstatus.search');

			case 'create':
				if (auth()->user()->can('create', \App\Matchstatus::class))
					return route('office.matchstatus.create');
				else
					return null;

			case 'control':
				return 'search';
		}
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
					return route('office.matchstatus.show', $this->record->id);
				else
					return null;

			case 'foreground':
				return $this->record->color_fg;

			case 'background':
				return $this->record->color_bg;

			case 'control':
				return 'text';
		}
	}

	public function fieldSlug()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->slug;

			case 'control':
				return 'text';
		}
	}

	public function fieldColorBg()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->color_bg;

			case 'control':
				return 'text';
		}
	}

	public function fieldColorFg()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->color_fg;

			case 'control':
				return 'text';
		}
	}

	// Counters

	public function fieldMatchesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->matches_count;
		}
	}
}
