@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Forecastcomment::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.forecastcomment.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $forecastcomments,
			'model'		=> \App\Forecastcomment::class,
			'fields'	=> [
				'posted_at',
				'commentstatus',
				'message',
				'forecast',
				'user',
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
