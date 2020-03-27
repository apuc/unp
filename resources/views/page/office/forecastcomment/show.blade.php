@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.forecastcomment.index')
			])

			@can('update', $forecastcomment)
				@include('control.office.toolbar.edit', [
					'url' => route('office.forecastcomment.edit', [
						'forecastcomment' => $forecastcomment->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $forecastcomment,
				'model'		=> \App\Forecastcomment::class,
				'groups'	=> [
					'properties' => [
						'forecast',
						'user',
						'commentstatus',
						'posted_at',
						'message',
					]
				],
			])
		@endslot
	@endcomponent
@endsection
