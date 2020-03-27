@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.forecaststatus.index')
			])

			@can('update', $forecaststatus)
				@include('control.office.toolbar.edit', [
					'url' => route('office.forecaststatus.edit', [
						'forecaststatus' => $forecaststatus->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $forecaststatus,
				'model'		=> \App\Forecaststatus::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'color_bg',
						'color_fg',
					],
					'statistics' => [
						'forecasts_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Forecast::class,
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
					'user',
					'rate',
					'bet',
					'posted_at',
					'description',
					'forecastcomments_count',
					'forecastpictures_count',
				],
				'values'  	=> [
					'forecaststatus_id' => $forecaststatus->id
				],
			])
		@endslot
	@endcomponent
@endsection

