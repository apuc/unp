@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.participant.index')
			])

			@can('update', $participant)
				@include('control.office.toolbar.edit', [
					'url' => route('office.participant.edit', [
						'participant' => $participant->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $participant,
				'model'		=> \App\Participant::class,
				'groups'	=> [
					'properties' => [
						'tournament',
						'season',
						'stage',
						'match',
						'team',
						'score',
						'position',
						'external_id',
					],
				],
			])
		@endslot
	@endcomponent
@endsection

