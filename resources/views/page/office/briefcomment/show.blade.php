@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.briefcomment.index')
			])

			@can('update', $briefcomment)
				@include('control.office.toolbar.edit', [
					'url' => route('office.briefcomment.edit', [
						'briefcomment' => $briefcomment->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $briefcomment,
				'model'		=> \App\Briefcomment::class,
				'groups'	=> [
					'properties' => [
						'brief',
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

