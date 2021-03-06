@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Outcomesubtype::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.outcomesubtype.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $outcomesubtypes,
			'model'		=> \App\Outcomesubtype::class,
			'fields'	=> [
				'name',
				'slug',
				'position',
				'is_enabled',
				'external_id',
				'external_name',
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
