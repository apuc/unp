@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.briefpicture.index')
			])

			@can('update', $briefpicture)
				@include('control.office.toolbar.edit', [
					'url' => route('office.briefpicture.edit', [
						'briefpicture' => $briefpicture->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $briefpicture,
				'model'		=> \App\Briefpicture::class,
				'groups'	=> [
					'properties' => [
						'name',
						'brief',
						'picture',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

