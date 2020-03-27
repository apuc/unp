<?php

namespace App\Entities;

class HelpsectionEntity extends AbstractEntity
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
					return route('office.helpsection.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.helpsection.search');

			case 'create':
				if (auth()->user()->can('create', \App\Helpsection::class))
					return route('office.helpsection.create');
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
					return route('office.helpsection.show', $this->record->id);
				else
					return null;

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

	public function fieldIcon()
	{
		switch($this->property) {
			case 'type':
				return 'picture';

			case 'value':
				return $this->record->icon;

			case 'required':
				return true;

			case 'control':
				return 'picture';
		}
	}

	public function fieldAnnounce()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->announce;

			case 'control':
				return 'textarea';
		}
	}

	public function fieldTextHeader()
	{
		switch($this->property) {
			case 'type':
				return 'html';

			case 'value':
				return $this->record->text_header;

			case 'control':
				return 'htmleditor';
		}
	}

	public function fieldTextFooter()
	{
		switch($this->property) {
			case 'type':
				return 'html';

			case 'value':
				return $this->record->text_footer;

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

	public function fieldSeoTitle()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->seo_title;

			case 'control':
				return 'text';
		}
	}

	public function fieldSeoKeywords()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->seo_keywords;

			case 'control':
				return 'textarea';
		}
	}

	public function fieldSeoDescription()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->seo_description;

			case 'control':
				return 'textarea';
		}
	}

	// Counters

	public function fieldHelpquestionsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->helpquestions_count;
		}
	}
}
