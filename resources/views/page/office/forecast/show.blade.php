@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.forecast.index')
			])

			@can('update', $forecast)
				@include('control.office.toolbar.edit', [
					'url' => route('office.forecast.edit', [
						'forecast' => $forecast->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $forecast,
				'model'		=> \App\Forecast::class,
				'groups'	=> [
					'properties' => [
						'id',
						'sport',
						'outcome',
						'outcometype',
						'outcomesubtype',
						'outcomescope',
						'bookmaker',
						'tournament',
						'season',
						'stage',
						'match',
						'started_at',
						'user',
						'forecaststatus',
						'rate',
						'bet',
						'posted_at',
						'description',
					],
					'statistics' => [
						'forecastcomments_count',
						'forecastpictures_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Forecastcomment::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Forecastpicture::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $forecastcomments,
				'model'		=> \App\Forecastcomment::class,
				'fields'	=> [
					'user',
					'commentstatus',
					'posted_at',
					'message',
				],
				'values'	=> [
					'forecast_id' => $forecast->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $forecastpictures,
				'model'		=> \App\Forecastpicture::class,
				'fields'	=> [
					'name',
					'picture',
				],
				'values'	=> [
					'forecast_id' => $forecast->id
				],
			])
		@endslot
	@endcomponent
@endsection

