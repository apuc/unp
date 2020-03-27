@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.post.index')
			])

			@can('update', $post)
				@include('control.office.toolbar.edit', [
					'url' => route('office.post.edit', [
						'post' => $post->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $post,
				'model'		=> \App\Post::class,
				'groups'	=> [
					'properties' => [
						'name',
						'sport',
						'user',
						'poststatus',
						'picture',
						'picture_author',
						'announce',
						'content',
						'posted_at',
					],
					'seo' => [
						'seo_title',
						'seo_keywords',
						'seo_description',
					],
					'statistics' => [
						'postcomments_count',
						'postpictures_count',
						'posttags_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Postcomment::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Postpicture::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Posttag::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Posttournament::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $postcomments,
				'model'		=> \App\Postcomment::class,
				'fields'	=> [
					'user',
					'commentstatus',
					'posted_at',
					'message',
				],
				'values'	=> [
					'post_id' => $post->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $postpictures,
				'model'		=> \App\Postpicture::class,
				'fields'	=> [
					'name',
					'picture',
				],
				'values'	=> [
					'post_id' => $post->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $posttags,
				'model'		=> \App\Posttag::class,
				'fields'	=> [
					'tag',
				],
				'values'	=> [
					'post_id' => $post->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $posttournaments,
				'model'		=> \App\Posttournament::class,
				'fields'	=> [
					'tournament',
				],
				'values'	=> [
					'post_id' => $post->id
				],
			])
		@endslot
	@endcomponent
@endsection

