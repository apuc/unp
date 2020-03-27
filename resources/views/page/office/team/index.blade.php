@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Team::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.team.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('page.office.team.filter-button')
		</div>
		@include('page.office.team.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $teams,
			'model'		=> \App\Team::class,
			'fields'	=> [
				'name',
				'sport',
				'country',
				'gender',
				'logo',
				'external_id',
				'participants_count',
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
