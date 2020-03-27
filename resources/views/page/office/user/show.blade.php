@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.user.index')
			])

			@can('update', $user)
				@include('control.office.toolbar.edit', [
					'url' => route('office.user.edit', [
						'user' => $user->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $user,
				'model'	=> \App\User::class,
				'groups'	=> [
					'properties' => [
						'login',
						'name',
						'role',
						'born_at',
						'email',
						'phone',
						'avatar',
						'about',
						'balance',
						'visited_at',
					],
					'statistics' => [
						'forecasts_count',
						'stat_profit',
						'stat_wins',
						'stat_losses',
						'stat_draws',
						'stat_offer',
						'stat_bet',
						'stat_luck',
						'posts_count',
						'postcomments_count',
						'briefs_count',
						'briefcomments_count',
						'forecastcomments_count',
						'issues_count',
						'answers_count',
						'usersocials_count',
						'notices_count',
						'events_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Forecast::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Post::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Postcomment::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Brief::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Briefcomment::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Forecastcomment::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Issue::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Answer::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Usersocial::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Notice::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Event::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $forecasts,
				'model'		=> \App\Forecast::class,
				'fields'	=> [
					'sport',
					'outcome',
					'bookmaker',
					'match',
					'started_at',
					'forecaststatus',
					'rate',
					'bet',
					'posted_at',
					'description',
					'forecastcomments_count',
					'forecastpictures_count',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $posts,
				'model'		=> \App\Post::class,
				'fields'	=> [
					'name',
					'sport',
					'poststatus',
					'picture',
					'posted_at',
					'postcomments_count',
					'postpictures_count',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $postcomments,
				'model'		=> \App\Postcomment::class,
				'fields'	=> [
					'post',
					'commentstatus',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $briefs,
				'model'		=> \App\Brief::class,
				'fields'	=> [
					'name',
					'sport',
					'briefstatus',
					'picture',
					'posted_at',
					'briefcomments_count',
					'briefpictures_count',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $briefcomments,
				'model'		=> \App\Briefcomment::class,
				'fields'	=> [
					'brief',
					'commentstatus',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $forecastcomments,
				'model'		=> \App\Forecastcomment::class,
				'fields'	=> [
					'forecast',
					'commentstatus',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $issues,
				'model'		=> \App\Issue::class,
				'fields'	=> [
					'id',
					'posted_at',
					'issuetype',
					'issuestatus',
					'author',
					'email',
					'message',
					'answers_count',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $answers,
				'model'		=> \App\Answer::class,
				'fields'	=> [
					'id',
					'issue',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $usersocials,
				'model'		=> \App\Usersocial::class,
				'fields'	=> [
					'social',
					'account',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $notices,
				'model'		=> \App\Notice::class,
				'fields'	=> [
					'posted_at',
					'event',
					'noticetype',
					'noticestatus',
					'message',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $events,
				'model'		=> \App\Event::class,
				'fields'	=> [
					'happened_at',
					'action',
					'visitor',
					'params',
					'notices_count',
				],
				'values'  	=> [
					'user_id'			=> $user->id,
				],
			])
		@endslot

	@endcomponent
@endsection

