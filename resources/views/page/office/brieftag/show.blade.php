@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.brieftag.index')
			])

			@can('update', $brieftag)
				@include('control.office.toolbar.edit', [
					'url' => route('office.brieftag.edit', [
						'brieftag' => $brieftag->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $brieftag,
				'model'		=> \App\Brieftag::class,
				'groups'	=> [
					'properties' => [
						'brief',
						'tag',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

