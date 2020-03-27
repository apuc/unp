@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Action::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.action.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $actions,
			'model'		=> \App\Action::class,
			'fields'	=> [
				'actiongroup',
				'name',
				'slug',
				'description',
				'events_count',
				'noticebans_count',
				'noticetemplates_count',
			],
		])
	</div>

	@include('partial.office.shell.modal-editor', [
		'action' => 'create'
    ])

	@include('partial.office.shell.modal-editor', [
    	'action' => 'edit'
	])
@endsection
