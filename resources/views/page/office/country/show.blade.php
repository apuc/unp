@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.country.index')
			])

			@can('update', $country)
				@include('control.office.toolbar.edit', [
					'url' => route('office.country.edit', [
						'country' => $country->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $country,
				'model'		=> \App\Country::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'flag',
						'is_enabled',
					],
					'external' => [
						'external_id',
						'external_name',
					],
					'statistics' => [
						'teams_count',
						'stages_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Team::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Stage::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $teams,
				'model'		=> \App\Team::class,
				'fields'	=> [
					'name',
					'sport',
					'gender',
					'logo',
					'external_id',
				],
				'values'	=> [
					'country_id' => $country->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $stages,
				'model'		=> \App\Stage::class,
				'fields'	=> [
					'name',
					'season',
					'gender',
					'external_id',
					'matches_count',
				],
				'values'	=> [
					'country_id' => $country->id
				],
			])
		@endslot
	@endcomponent
@endsection
