<?php

namespace App\Entities;

use Morph;

class UserEntity extends AbstractEntity
{
	public function key()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'id':
				return $this->record->id;

			case 'value':
				return trans('option.office.user', [
					'name'	=> $this->record->login,
					'email'	=> $this->record->email,
					'phone'	=> filled($phone = Morph::phone($this->record->phone, '+7 (%d%d%d) %d%d%d-%d%d-%d%d')) ? $phone : null,
				]);

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.user.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.user.search');

			case 'create':
				if (auth()->user()->can('create', \App\User::class))
					return route('office.user.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldRole()
	{
		return RoleEntity::relation($this, $this->record->role);
	}

	// Fields

	public function fieldLogin()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->login;

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.user.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldName()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->name;

			case 'control':
				return 'text';
		}
	}

	public function fieldBornAt()
	{
		switch($this->property) {
			case 'type':
				return 'date';

			case 'value':
				return $this->record->born_at;

			case 'control':
				return 'date';
		}
	}

	public function fieldEmail()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->email;

			case 'url':
				return 'mailto:' . $this->record->email;

			case 'control':
				return 'text';
		}
	}

	public function fieldPassword()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'control':
				return 'password';
		}
	}

	public function fieldPasswordConfirmation()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'control':
				return 'password';
		}
	}

	public function fieldPhone()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return filled($phone = Morph::phone($this->record->phone, '+7 (%d%d%d) %d%d%d-%d%d-%d%d')) ? $phone : null;

			case 'mask':
				return '+7 (000) 000-00-00';

			case 'control':
				return 'text';
		}
	}

	public function fieldAvatar()
	{
		switch($this->property) {
			case 'type':
				return 'picture';

			case 'value':
				return $this->record->avatar;

			case 'required':
				return false;

			case 'control':
				return 'picture';
		}
	}

	public function fieldBalance()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->balance;

			case 'control':
				return 'text';
		}
	}

	public function fieldVisitedAt()
	{
		switch($this->property) {
			case 'type':
				return 'datetime';

			case 'value':
				return $this->record->visited_at;

			case 'control':
				return 'datetime';
		}
	}

	public function fieldStatProfit()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_profit;

			case 'control':
				return 'text';
		}
	}

	public function fieldStatRoi()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_roi;

			case 'control':
				return 'text';
		}
	}

	public function fieldStatForecasts()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_forecasts;

			case 'control':
				return 'text';
		}
	}

	public function fieldStatBriefs()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_briefs;

			case 'control':
				return 'text';
		}
	}

	public function fieldStatPosts()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_posts;

			case 'control':
				return 'text';
		}
	}

	public function fieldStatWins()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_wins;

			case 'control':
				return 'text';
		}
	}

	public function fieldStatLosses()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_losses;

			case 'control':
				return 'text';
		}
	}

	public function fieldStatDraws()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_draws;

			case 'control':
				return 'text';
		}
	}

	public function fieldStatOffer()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_offer;

			case 'control':
				return 'text';
		}
	}

	public function fieldStatBet()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_bet;

			case 'control':
				return 'text';
		}
	}

	public function fieldStatLuck()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_luck;

			case 'control':
				return 'text';
		}
	}

	public function fieldStatComments()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stat_comments;

			case 'control':
				return 'text';
		}
	}

	public function fieldAbout()
	{
		switch($this->property) {
			case 'type':
				return 'text';

			case 'value':
				return $this->record->about;

			case 'control':
				return 'textarea';
		}
	}

	// Counters

	public function fieldForecastsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->forecasts_count;
		}
	}

	public function fieldPostsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->posts_count;
		}
	}

	public function fieldBriefsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->briefs_count;
		}
	}

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

	public function fieldIssuesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->issues_count;
		}
	}

	public function fieldAnswersCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->answers_count;
		}
	}

	public function fieldUsersocialsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->usersocials_count;
		}
	}

	public function fieldNoticesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->notices_count;
		}
	}

	public function fieldEventsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->events_count;
		}
	}
}
