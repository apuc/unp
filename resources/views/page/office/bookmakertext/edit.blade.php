@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.bookmakertext.show', $bookmakertext->id),
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
