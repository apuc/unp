@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.helppicture.index')
			])

			@can('update', $helppicture)
				@include('control.office.toolbar.edit', [
					'url' => route('office.helppicture.edit', [
						'helppicture' => $helppicture->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $helppicture,
				'model'		=> \App\Helppicture::class,
				'groups'	=> [
					'properties' => [
						'helpquestion',
						'name',
						'picture',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

