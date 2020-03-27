@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.bookmakerpicture.index')
			])

			@can('update', $bookmakerpicture)
				@include('control.office.toolbar.edit', [
					'url' => route('office.bookmakerpicture.edit', [
						'bookmakerpicture' => $bookmakerpicture->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $bookmakerpicture,
				'model'		=> \App\Bookmakerpicture::class,
				'groups'	=> [
					'properties' => [
						'name',
						'bookmakertext',
						'picture',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

