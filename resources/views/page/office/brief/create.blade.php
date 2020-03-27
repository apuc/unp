@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.brief.index'),
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

