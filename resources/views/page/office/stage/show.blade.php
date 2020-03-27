@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.stage.index')
			])

			@can('update', $stage)
				@include('control.office.toolbar.edit', [
					'url' => route('office.stage.edit', [
						'stage' => $stage->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $stage,
				'model'		=> \App\Stage::class,
				'groups'	=> [
					'properties' => [
						'name',
						'tournament',
						'season',
						'gender',
						'country',
						'external_id',
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

					'participants_count',
					'forecasts_count',
				],
				'values'	=> [
					'stage_id' => $stage->id
				],
			])
		@endslot
	@endcomponent
@endsection

