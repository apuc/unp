@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.sitepicture.index')
			])

			@can('update', $sitepicture)
				@include('control.office.toolbar.edit', [
					'url' => route('office.sitepicture.edit', [
						'sitepicture' => $sitepicture->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $sitepicture,
				'model'		=> \App\Sitepicture::class,
				'groups'	=> [
					'properties' => [
						'name',
						'sitetext',
						'picture',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

