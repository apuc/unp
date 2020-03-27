@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.actiongroup.index')
			])

			@can('update', $actiongroup)
				@include('control.office.toolbar.edit', [
					'url' => route('office.actiongroup.edit', [
						'actiongroup' => $actiongroup->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $actiongroup,
				'model'		=> \App\Actiongroup::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'actions_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Action::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $actions,
				'model'		=> \App\Action::class,
				'fields'	=> [
					'name',
					'slug',
					'description',
					'events_count',
					'noticebans_count',
					'noticetemplates_count',
				],
				'values'	=> [
					'actiongroup_id' => $actiongroup->id
				],
			])
		@endslot

	@endcomponent
@endsection

