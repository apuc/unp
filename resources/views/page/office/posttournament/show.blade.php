@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.posttournament.index')
			])

			@can('update', $posttournament)
				@include('control.office.toolbar.edit', [
					'url' => route('office.posttournament.edit', [
						'posttournament' => $posttournament->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $posttournament,
				'model'		=> \App\Posttournament::class,
				'groups'	=> [
					'properties' => [
						'post',
						'tournament',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

