<?php

namespace App\Entities;

class AnswerEntity extends AbstractEntity
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
					return route('office.answer.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.answer.search');

			case 'create':
				if (auth()->user()->can('create', \App\Answer::class))
					return route('office.answer.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldIssue()
	{
		return IssueEntity::relation($this, $this->record->issue);
	}

	public function fieldUser()
	{
		return UserEntity::relation($this, $this->record->user);
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
					return route('office.answer.show', $this->record->id);
				else
					return null;
		}
	}

	public function fieldMessage()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->message;

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
}
