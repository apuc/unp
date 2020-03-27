@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Match::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.match.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $matches,
			'model'		=> \App\Match::class,
			'fields'	=> [
				'name',
				'tournament',
				'season',
				'stage',
				'started_at',
				'matchstatus',

				'bookmaker1',
				'odds1_current',
				'odds1_old',

				'bookmakerx',
				'oddsx_current',
				'oddsx_old',

				'bookmaker2',
				'odds2_current',
				'odds2_old',

				'external_id',

				'participants_count',
				'forecasts_count',
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
