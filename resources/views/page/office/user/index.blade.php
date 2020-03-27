@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\User::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.user.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('page.office.user.filter-button')
		</div>
		@include('page.office.user.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $users,
			'model'		=> \App\User::class,
			'fields'	=> [
				'login',
				'name',
				'avatar',
				'role',
				'born_at',
				'email',
				'phone',
				'balance',
				'stat_roi',
				'stat_profit',
				'forecasts_count',
				'posts_count',
				'briefs_count',
				'visited_at',
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