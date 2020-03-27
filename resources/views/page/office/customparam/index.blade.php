@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Customparam::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.customparam.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $customparams,
			'model'		=> \App\Customparam::class,
			'fields'	=> [
				'name',
				'slug',
				'customgroup',
				'customtype',
				'value_string',
				'value_integer',
				'value_float',
				'value_text',
				'value_boolean',
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
