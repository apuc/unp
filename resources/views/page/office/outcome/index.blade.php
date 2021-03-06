@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Outcome::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.outcome.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $outcomes,
			'model'		=> \App\Outcome::class,
			'fields'	=> [
				'tournament',
				'season',
				'stage',
				'match',
				'team',
				'outcometype',
				'outcomescope',
				'outcomesubtype',
				'external_id',
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
