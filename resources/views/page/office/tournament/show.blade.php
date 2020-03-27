@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.tournament.index')
			])

			@can('update', $tournament)
				@include('control.office.toolbar.edit', [
					'url' => route('office.tournament.edit', [
						'tournament' => $tournament->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $tournament,
				'model'		=> \App\Tournament::class,
				'groups'	=> [
					'properties' => [
						'name',
						'sport',
						'gender',
						'logo',
						'external_id',
						'tournamenttype',
						'position',
						'is_top',
					],
					'statistics' => [
						'seasons_count',
						'tournamentposts_count',
						'tournamentbriefs_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Season::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Posttournament::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Brieftournament::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $seasons,
				'model'		=> \App\Season::class,
				'fields'	=> [
					'name',
					'external_id',
					'stages_count',
				],
				'values'	=> [
					'tournament_id' => $tournament->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $posttournaments,
				'model'		=> \App\Posttournament::class,
				'fields'	=> [
					'post',
				],
				'values'	=> [
					'tournament_id' => $tournament->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $brieftournaments,
				'model'		=> \App\Brieftournament::class,
				'fields'	=> [
					'brief',
				],
				'values'	=> [
					'tournament_id' => $tournament->id
				],
			])
		@endslot
	@endcomponent
@endsection

