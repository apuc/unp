@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.bookmakertext.index'),
		'dataset'   => $bookmakertext,
		'model'     => \App\Bookmakertext::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'bookmaker',
				'picture',
				'announce',
				'content',
				'is_enabled',
			],
			'seo' => [
				'seo_title',
				'seo_keywords',
				'seo_description',
			],
		],
	])
@endsection

