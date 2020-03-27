@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.forecastpicture.index')
			])

			@can('update', $forecastpicture)
				@include('control.office.toolbar.edit', [
					'url' => route('office.forecastpicture.edit', [
						'forecastpicture' => $forecastpicture->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $forecastpicture,
				'model'		=> \App\Forecastpicture::class,
				'groups'	=> [
					'properties' => [
						'name',
						'forecast',
						'picture',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

