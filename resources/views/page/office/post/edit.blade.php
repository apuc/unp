@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.post.show', $post->id),
		'dataset'   => $post,
		'model'     => \App\Post::class,
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
		],
	])
@endsection
