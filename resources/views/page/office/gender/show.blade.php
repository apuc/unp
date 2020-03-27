@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.gender.index')
			])

			@can('update', $gender)
				@include('control.office.toolbar.edit', [
					'url' => route('office.gender.edit', [
						'gender' => $gender->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $gender,
				'model'		=> \App\Gender::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'tournaments_count',
						'stages_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Tournament::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Stage::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $tournaments,
				'model'		=> \App\Tournament::class,
				'fields'	=> [
					'sport',
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
					'gender_id' => $gender->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $stages,
				'model'		=> \App\Stage::class,
				'fields'	=> [
					'name',
					'season',
					'country',
					'external_id',
					'matches_count',
				],
				'values'	=> [
					'gender_id' => $gender->id
				],
			])
		@endslot
	@endcomponent
@endsection
