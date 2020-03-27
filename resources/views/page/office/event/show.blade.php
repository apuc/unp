@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.event.index')
			])

			@can('update', $event)
				@include('control.office.toolbar.edit', [
					'url' => route('office.event.edit', [
						'event' => $event->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $event,
				'model'		=> \App\Event::class,
				'groups'	=> [
					'properties' => [
						'happened_at',
						'action',
						'user',
						'visitor',
						'params',
					],
					'statistics' => [
						'notices_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Notice::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $notices,
				'model'		=> \App\Notice::class,
				'fields'	=> [
					'posted_at',
					'noticetype',
					'noticestatus',
					'user',
					'message',
				],
				'values'	=> [
					'event_id' => $event->id
				],
			])
		@endslot
	@endcomponent
@endsection

