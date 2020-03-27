@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.sport.index')
			])

			@can('update', $sport)
				@include('control.office.toolbar.edit', [
					'url' => route('office.sport.edit', [
						'sport' => $sport->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $sport,
				'model'		=> \App\Sport::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'icon',
						'has_odds',
						'position',
						'external_id',
						'external_name',
						'is_enabled',
					],
					'statistics' => [
						'teams_count',
						'tournamenttypes_count',
						'tournaments_count',
						'posts_count',
						'briefs_count',
						'forecasts_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Team::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Tournamenttype::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Tournament::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Post::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Brief::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Forecast::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $teams,
				'model'		=> \App\Team::class,
				'fields'	=> [
					'name',
					'country',
					'gender',
					'logo',
					'external_id',
					'participants_count',
				],
				'values'	=> [
					'sport_id' => $sport->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $tournamenttypes,
				'model'		=> \App\Tournamenttype::class,
				'fields'	=> [
					'name',
				],
				'values'	=> [
					'sport_id' => $sport->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $tournaments,
				'model'		=> \App\Tournament::class,
				'fields'	=> [
					'gender',
					'tournamenttype',
					'name',
					'logo',
					'external_id',
					'position',
					'is_top',
					'seasons_count',
					'tournamentposts_count',
					'tournamentbriefs_count',
				],
				'values'	=> [
					'sport_id' => $sport->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $posts,
				'model'		=> \App\Post::class,
				'fields'	=> [
					'name',
					'user',
					'poststatus',
					'picture',
					'posted_at',
					'postcomments_count',
					'postpictures_count',
				],
				'values'	=> [
					'sport_id' => $sport->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $briefs,
				'model'		=> \App\Brief::class,
				'fields'	=> [
					'name',
					'user',
					'briefstatus',
					'picture',
					'posted_at',
					'briefcomments_count',
					'briefpictures_count',
				],
				'values'	=> [
					'sport_id' => $sport->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $forecasts,
				'model'		=> \App\Forecast::class,
				'fields'	=> [
					'outcome',
					'bookmaker',
					'match',
					'started_at',
					'user',
					'forecaststatus',
					'rate',
					'bet',
					'posted_at',
					'description',
					'forecastcomments_count',
					'forecastpictures_count',
				],
				'values'	=> [
					'sport_id' => $sport->id
				],
			])
		@endslot
	@endcomponent
@endsection

