<?php

namespace App\Entities;

class IssueEntity extends AbstractEntity
{
	public function key()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'id':
				return $this->record->id;

			case 'value':
				return trans('option.office.issue', [
					'id'		=> code($this->record->id),
					'posted_at'	=> $this->record->posted_at,
				]);

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.issue.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.issue.search');

			case 'create':
				if (auth()->user()->can('create', \App\Issue::class))
					return route('office.issue.create');
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

	public function fieldIssuetype()
	{
		return IssuetypeEntity::relation($this, $this->record->issuetype);
	}

	public function fieldIssuestatus()
	{
		return IssuestatusEntity::relation($this, $this->record->issuestatus);
	}

	// Fields

	public function fieldId()
	{
		switch($this->property) {
			case 'type':
				return 'id';

			case 'value':
				return code($this->record->id);

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.issue.show', $this->record->id);
				else
					return null;
		}
	}

	public function fieldAuthor()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->author;

			case 'control':
				return 'text';
		}
	}

	public function fieldEmail()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->email;

			case 'control':
				return 'text';
		}
	}

	public function fieldMessage()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->slug;

			case 'control':
				return 'textarea';
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

	// Counters

	public function fieldAnswersCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->answers_count;
		}
	}
}
