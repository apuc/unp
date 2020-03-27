@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Forecast::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.forecast.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('page.office.forecast.filter-button')
		</div>
		@include('page.office.forecast.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $forecasts,
			'model'		=> \App\Forecast::class,
			'fields'	=> [
				'id',
				'posted_at',
				'forecaststatus',
				'user',
				'sport',
				'tournament',
				'season',
				'stage',
				'match',
				'started_at',
				'outcometype',
				'outcomesubtype',
				'outcomescope',
				'outcome',
				'bookmaker',
				'rate',
				'bet',
				'description',
				'forecastcomments_count',
				'forecastpictures_count',
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
