@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.brief.show', $brief->id),
		'dataset'   => $brief,
		'model'     => \App\Brief::class,
		'groups'	=> [
			'properties' => [
				'name',
				'sport',
				'user',
				'briefstatus',
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
