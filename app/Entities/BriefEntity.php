<?php

namespace App\Entities;

class BriefEntity extends AbstractEntity
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
					return route('office.brief.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.brief.search');

			case 'create':
				if (auth()->user()->can('create', \App\Brief::class))
					return route('office.brief.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldUser()
	{
		return UserEntity::relation($this, $this->record->user);
	}

	public function fieldSport()
	{
		return SportEntity::relation($this, $this->record->sport);
	}

	public function fieldBriefstatus()
	{
		return BriefstatusEntity::relation($this, $this->record->briefstatus);
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
					return route('office.brief.show', $this->record->id);
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

	public function fieldContent()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->content;

			case 'control':
				return 'htmleditor';
		}
	}

	public function fieldPostedAt()
	{
		switch($this->property) {
			case 'type':
				return 'datetime';

			case 'value':
				return $this->record->posted_at;

			case 'control':
				return 'datetime';
		}
	}

	public function fieldPictureAuthor()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->picture_author;

			case 'control':
				return 'text';
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

	public function fieldBriefcommentsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->briefcomments_count;
		}
	}

	public function fieldBriefpicturesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->briefpictures_count;
		}
	}

	public function fieldBrieftagsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->brieftags_count;
		}
	}

	public function fieldBrieftournamentsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->brieftournaments_count;
		}
	}
}
