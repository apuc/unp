@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.team.index')
			])

			@can('update', $team)
				@include('control.office.toolbar.edit', [
					'url' => route('office.team.edit', [
						'team' => $team->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $team,
				'model'		=> \App\Team::class,
				'groups'	=> [
					'properties' => [
						'name',
						'sport',
						'country',
						'gender',
						'logo',
						'external_id',
					],
					'statistics' => [
						'participants_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Participant::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $participants,
				'model'		=> \App\Participant::class,
					'fields'	=> [
					'match',
					'score',
					'position',
					'external_id',
				],
				'values'	=> [
					'team_id' => $team->id
				],
			])
		@endslot
	@endcomponent
@endsection

