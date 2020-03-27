@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.outcome.index')
			])

			@can('update', $outcome)
				@include('control.office.toolbar.edit', [
					'url' => route('office.outcome.edit', [
						'outcome' => $outcome->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $outcome,
				'model'		=> \App\Outcome::class,
				'groups'	=> [
					'properties' => [
						'tournament',
						'season',
						'stage',
						'match',
						'team',
						'outcometype',
						'outcomescope',
						'outcomesubtype',
					],
					'external' => [
						'external_id',
					],
				],
			])
		@endslot
	@endcomponent
@endsection

