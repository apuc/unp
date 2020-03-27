@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.match.index')
			])

			@can('update', $match)
				@include('control.office.toolbar.edit', [
					'url' => route('office.match.edit', [
						'match' => $match->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $match,
				'model'		=> \App\Match::class,
				'groups'	=> [
					'properties' => [
						'name',
						'tournament',
						'season',
						'stage',
						'started_at',
						'matchstatus',

						'bookmaker1',
						'odds1_current',
						'odds1_old',

						'bookmakerx',
						'oddsx_current',
						'oddsx_old',

						'bookmaker2',
						'odds2_current',
						'odds2_old',

						'external_id',
					],
					'statistics' => [
						'participants_count',
						'forecasts_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Participant::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Forecast::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $participants,
				'model'		=> \App\Participant::class,
				'fields'	=> [
					'team',
					'score',
					'position',
					'external_id',
				],
				'values'	=> [
					'match_id' => $match->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $forecasts,
				'model'		=> \App\Forecast::class,
				'fields'	=> [
					'sport',
					'outcome',
					'bookmaker',
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
					'match_id' => $match->id
				],
			])
		@endslot
	@endcomponent
@endsection
