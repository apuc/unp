@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Brief::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.brief.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('page.office.brief.filter-button')
		</div>
		@include('page.office.brief.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $briefs,
			'model'		=> \App\Brief::class,
			'fields'	=> [
				'posted_at',
				'briefstatus',
				'name',
				'sport',
				'user',
				'picture',
				'picture_author',
				'briefcomments_count',
				'briefpictures_count',
				'brieftags_count',
				'brieftournaments_count',
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
