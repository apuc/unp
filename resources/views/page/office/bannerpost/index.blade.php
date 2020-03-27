@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Bannerpost::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.bannerpost.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $bannerposts,
			'model'		=> \App\Bannerpost::class,
			'fields'	=> [
				'banner',
				'sitesection',
				'bannerplace',
				'margin',
				'started_at',
				'finished_at',
				'view_limit',
				'view_amount',
				'click_limit',
				'click_amount',
				'is_enabled',
				'is_debug',
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
