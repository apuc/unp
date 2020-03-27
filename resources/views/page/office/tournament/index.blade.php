@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Tournament::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.tournament.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('page.office.tournament.filter-button')
		</div>
		@include('page.office.tournament.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $tournaments,
			'model'		=> \App\Tournament::class,
			'fields'	=> [
				'id',
				'name',
				'sport',
				'gender',
				'logo',
				'external_id',
				'tournamenttype',
				'position',
				'is_top',
				'seasons_count',
				'tournamentposts_count',
				'tournamentbriefs_count',
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
