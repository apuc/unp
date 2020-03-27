@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.action.index')
			])

			@can('update', $action)
				@include('control.office.toolbar.edit', [
					'url' => route('office.action.edit', [
						'action' => $action->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $action,
				'model'		=> \App\Action::class,
				'groups'	=> [
					'properties' => [
						'actiongroup',
						'name',
						'slug',
						'description',
					],
					'statistics' => [
						'events_count',
						'noticebans_count',
						'noticetemplates_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Event::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Noticeban::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Noticetemplate::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $events,
				'model'		=> \App\Event::class,
				'fields'	=> [
					'happened_at',
					'user',
					'visitor',
					'params',
					'notices_count',
				],
				'values'	=> [
					'action_id' => $action->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $noticebans,
				'model'		=> \App\Noticeban::class,
				'fields'	=> [
					'noticetype',
					'user',
				],
				'values'	=> [
					'action_id' => $action->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $noticetemplates,
				'model'		=> \App\Noticetemplate::class,
				'fields'	=> [
					'noticetype',
					'role',
				],
				'values'	=> [
					'action_id' => $action->id
				],
			])
		@endslot
	@endcomponent
@endsection
