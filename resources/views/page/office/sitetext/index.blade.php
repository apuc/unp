@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Sitetext::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.sitetext.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $sitetexts,
			'model'		=> \App\Sitetext::class,
			'fields'	=> [
				'name',
				'slug',
				'sitesection',
				'title',
				'picture',
				'is_enabled',
				'position',
				'sitepictures_count',
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
