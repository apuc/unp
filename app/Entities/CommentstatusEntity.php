<?php

namespace App\Entities;

class CommentstatusEntity extends AbstractEntity
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
					return route('office.commentstatus.show', $this->record->id);
				else
					return null;

			case 'foreground':
				return $this->record->color_fg;

			case 'background':
				return $this->record->color_bg;

			case 'search':
				return route('office.commentstatus.search');

			case 'create':
				if (auth()->user()->can('create', \App\Commentstatus::class))
					return route('office.commentstatus.create');
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
					return route('office.commentstatus.show', $this->record->id);
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

			case 'default':
				return str_slug($this->record->name);

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

	// Relations

	public function fieldPostcommentsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->postcomments_count;
		}
	}

	public function fieldBriefcommentsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->briefcomments_count;
		}
	}

	public function fieldForecastcommentsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->forecastcomments_count;
		}
	}
}
