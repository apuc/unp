@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.matchstatus.index')
			])

			@can('update', $matchstatus)
				@include('control.office.toolbar.edit', [
					'url' => route('office.matchstatus.edit', [
						'matchstatus' => $matchstatus->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $matchstatus,
				'model'		=> \App\Matchstatus::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'color_bg',
						'color_fg',
					],
					'statistics' => [
						'matches_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Match::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $matches,
				'model'		=> \App\Match::class,
				'fields'	=> [
					'name',
					'stage',
					'started_at',

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

					'participants_count',
					'forecasts_count',
				],
				'values'  	=> [
					'matchstatus_id' => $matchstatus->id
				],
			])
		@endslot
	@endcomponent
@endsection

