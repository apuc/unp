@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.benefit.index')
			])

			@can('update', $benefit)
				@include('control.office.toolbar.edit', [
					'url' => route('office.benefit.edit', [
						'benefit' => $benefit->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $benefit,
				'model'		=> \App\Benefit::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'icon',
						'announce',
						'url',
						'position',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

