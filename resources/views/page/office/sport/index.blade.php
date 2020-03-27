@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Sport::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.sport.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>
		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $sports,
			'model'		=> \App\Sport::class,
			'fields'	=> [
				'name',
				'slug',
				'icon',
				'has_odds',
				'position',
				'external_id',
				'external_name',
				'tournamenttypes_count',
				'is_enabled',
				'teams_count',
				'tournamenttypes_count',
				'tournaments_count',
				'posts_count',
				'briefs_count',
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
