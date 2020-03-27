@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Bannersection::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.bannersection.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $bannersections,
			'model'		=> \App\Bannersection::class,
			'fields'	=> [
				'bannersection',
				'bannerplace',
				'sitesection',
				'bannersections_count',
				'bannerposts_count',
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
