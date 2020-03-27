@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Country::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.country.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('page.office.country.filter-button')
		</div>
		@include('page.office.country.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $countries,
			'model'		=> \App\Country::class,
			'fields'	=> [
				'name',
				'slug',
				'flag',
				'is_enabled',
				'external_id',
				'external_name',
				'teams_count',
				'stages_count',
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
