@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.season.index')
			])

			@can('update', $season)
				@include('control.office.toolbar.edit', [
					'url' => route('office.season.edit', [
						'season' => $season->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $season,
				'model'		=> \App\Season::class,
				'groups'	=> [
					'properties' => [
						'tournament',
						'name',
						'external_id',
					],
					'statistics' => [
						'stages_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Stage::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $stages,
				'model'		=> \App\Stage::class,
				'fields'	=> [
					'name',
					'gender',
					'country',
					'external_id',
					'matches_count',
				],
				'values'	=> [
					'season_id' => $season->id
				],
			])
		@endslot
	@endcomponent
@endsection

