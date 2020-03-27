@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.brieftournament.index')
			])

			@can('update', $brieftournament)
				@include('control.office.toolbar.edit', [
					'url' => route('office.brieftournament.edit', [
						'brieftournament' => $brieftournament->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $brieftournament,
				'model'		=> \App\Brieftournament::class,
				'groups'	=> [
					'properties' => [
						'brief',
						'tournament',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

