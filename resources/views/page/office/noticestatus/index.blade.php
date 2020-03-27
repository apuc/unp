@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Noticestatus::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.noticestatus.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $noticestatuses,
			'model'		=> \App\Noticestatus::class,
			'fields'	=> [
				'name',
				'slug',
				'color_bg',
				'color_fg',
				'notices_count',
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
