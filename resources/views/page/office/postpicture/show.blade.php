@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.postpicture.index')
			])

			@can('update', $postpicture)
				@include('control.office.toolbar.edit', [
					'url' => route('office.postpicture.edit', [
						'postpicture' => $postpicture->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $postpicture,
				'model'		=> \App\Postpicture::class,
				'groups'	=> [
					'properties' => [
						'name',
						'post',
						'picture',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

