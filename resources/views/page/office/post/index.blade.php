@extends('layout.office.app')

@section('content')
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				@can('create', App\Post::class)
					@include('control.office.toolbar.create', [
						'url' => route('office.post.create'),
					])
				@endcan

				@include('control.office.toolbar.dataset')
			</div>

			@include('page.office.post.filter-button')
		</div>
		@include('page.office.post.filter')

		@include('control.office.plate.index', [
			'dataset'	=> $posts,
			'model'		=> \App\Post::class,
			'fields'	=> [
				'posted_at',
				'poststatus',
				'name',
				'sport',
				'user',
				'picture',
				'picture_author',
				'postcomments_count',
				'postpictures_count',
				'posttags_count',
				'posttournaments_count',
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
