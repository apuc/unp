@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Issue::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.issue.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $issues,
			'model'		=> \App\Issue::class,
			'fields'	=> [
				'id',
				'posted_at',
				'issuestatus',
				'user',
				'issuetype',
				'author',
				'email',
				'message',
				'answers_count',
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
