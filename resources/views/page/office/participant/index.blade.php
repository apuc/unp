@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Participant::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.participant.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $participants,
			'model'		=> \App\Participant::class,
			'fields'	=> [
				'tournament',
				'season',
				'stage',
				'match',
				'team',
				'score',
				'position',
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
